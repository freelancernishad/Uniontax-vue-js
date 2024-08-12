<?php

namespace App\Http\Controllers;

use App\Models\NidImage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;

class NidImageController extends Controller
{


    public function uploadNidImages(Request $request)
    {
        // Validate the request
        $request->validate([
            'applicant_national_id_front_attachment' => 'required|image',
            'applicant_national_id_back_attachment' => 'required|image',
        ]);

        // Handle front image upload
        if ($request->hasFile('applicant_national_id_front_attachment')) {
            $frontFile = $request->file('applicant_national_id_front_attachment');
            $frontFileName = time().$frontFile->getClientOriginalName();
            $frontFilePath = $frontFile->storeAs('nid_images/temp', $frontFileName, 'protected'); // Store temporarily
        } else {
            return response()->json(['error' => 'No front image file provided.'], 422);
        }

        // Handle back image upload
        if ($request->hasFile('applicant_national_id_back_attachment')) {
            $backFile = $request->file('applicant_national_id_back_attachment');
            $backFileName = time().$backFile->getClientOriginalName();
            $backFilePath = $backFile->storeAs('nid_images/temp', $backFileName, 'protected'); // Store temporarily
        } else {
            return response()->json(['error' => 'No back image file provided.'], 422);
        }

        // Extract text from front and back images
        $frontImagePath = url('files/' . $frontFilePath);
        $backImagePath = url('files/' . $backFilePath);

        return $frontImageText = $this->extractText($frontImagePath, 'front');
        $backImageText = $this->extractText($backImagePath, 'back');

        // Remove spaces from NID No.
        $nid_no = str_replace(' ', '', $frontImageText['NID No.'] ?? '');

        // Format date of birth
        $dateOfBirth = $frontImageText['Date of Birth'] ?? '';
        $formattedDateOfBirth = date('Y-m-d', strtotime($dateOfBirth));
        $date_of_birth = $formattedDateOfBirth;

        // Check for existing record
        $existingNidImage = NidImage::where('date_of_birth', $date_of_birth)
            ->where('nid_no', $nid_no)
            ->first();

        if ($existingNidImage) {
            return response()->json($existingNidImage);
            // Return existing record if found
            // return response()->json([
            //     'message' => 'Duplicate record found.',
            //     'existing_record' => $existingNidImage
            // ]);
        }

        // Create a new directory based on NID No.
        $year = now()->year;
        $month = now()->month;
        $day = now()->day;
        $directoryPath = "nid_images/{$year}/{$month}/{$day}/{$nid_no}";

        // Move the files to the new directory
        $frontFilePath = Storage::disk('protected')->move("nid_images/temp/{$frontFileName}", "{$directoryPath}/{$frontFileName}");
        $backFilePath = Storage::disk('protected')->move("nid_images/temp/{$backFileName}", "{$directoryPath}/{$backFileName}");

        // Save the file paths and extracted text to the model
        $nidImage = new NidImage();
        $nidImage->front_attachment = $frontFilePath;
        $nidImage->back_attachment = $backFilePath;

        // Map extracted front text
        $nidImage->name_bengali = $frontImageText['নাম'] ?? '';
        $nidImage->name_english = $frontImageText['Name'] ?? '';
        $nidImage->father_name = $frontImageText['পিতা'] ?? '';
        $nidImage->mother_name = $frontImageText['মাতা'] ?? '';
        $nidImage->nid_no = $nid_no;
        $nidImage->date_of_birth = $date_of_birth;

        // Map extracted back text
        $nidImage->village_road = $backImageText['গ্রাম/রাস্তা'] ?? '';
        $nidImage->post_office = $backImageText['ডাকঘর'] ?? '';
        $nidImage->blood_group = $backImageText['Blood Group'] ?? '';
        $nidImage->place_of_birth = $backImageText['Place of Birth'] ?? '';
        $nidImage->issue_date = $backImageText['Issue Date'] ?? '';
        $nidImage->postcode = $backImageText['পোস্টকোড'] ?? '';
        $nidImage->thana = $backImageText['থানা'] ?? '';
        $nidImage->district = $backImageText['জেলা'] ?? '';

        $nidImage->save();

        return response()->json($nidImage);
        // Return a response
        // return response()->json([
        //     'message' => 'NID images uploaded and text extracted successfully',
        //     'front_text' => $frontImageText,
        //     'back_text' => $backImageText
        // ]);
    }




    public function extractText($imagePath,$type='front')
    {
        // Image URL or path
        // $imagePath = $request->input('image_url');

        if (!$imagePath) {
            return response()->json(['error' => 'No image URL provided.'], 422);
        }

        // Instantiates a client
        $imageAnnotator = new ImageAnnotatorClient();

        // Load the image from the URL
        $image = file_get_contents($imagePath);

        // Performs text detection on the image file
        $response = $imageAnnotator->textDetection($image);
        $texts = $response->getTextAnnotations();

        // Extract text from response
        $text = '';
        foreach ($texts as $textAnnotation) {
            $text .= $textAnnotation->getDescription();
        }

        // Close the ImageAnnotatorClient
        $imageAnnotator->close();

        // Split text into chunks based on a delimiter (e.g., newline)
       return $textChunks = explode("\n", $text);

        // Get type parameter
        // $type = $request->input('type', 'front');

        if ($type === 'front') {
            $patterns = [
                'নাম' => '/নাম\s*(.*?)\s*\n/s',
                'Name' => '/Name\s*(.*?)\s*\n/s',
                'পিতা' => '/পিতা\s*(.*?)\s*\n/s',
                'মাতা' => '/মাতা\s*(.*?)\s*\n/s',
                'Date of Birth' => '/Date of Birth:\s*(.*?)\s*\n/s',
                'NID No.' => '/(?:NID No\.|ID No:\.)\s*(.*?)\s*\n/s',
            ];
        } elseif ($type === 'back') {
            $patterns = [
                'গ্রাম/রাস্তা' => '/গ্রাম\/রাস্তা:\s*(.*?),/',
                'ডাকঘর' => '/ডাকঘর:\s*(.*?)(?=\n)/s',
                'Blood Group' => '/Blood Group:\s*(.*?)(?=\n|$)/s',
                'Place of Birth' => '/Place of Birth:\s*(.*?)(?=\n|$)/s',
                'Issue Date' => '/Issue Date:\s*(.*?)\s*\n/',
            ];
        } else {
            return response()->json(['error' => 'Invalid type provided.'], 422);
        }

        // Initialize an array to store the extracted values
        $extractedValues = [];

        // Iterate through patterns and extract values
        foreach ($patterns as $key => $pattern) {
            if (preg_match($pattern, $text, $matches)) {
                $extractedValues[$key] = trim($matches[1]);
            } else {
                // Assign blank value if pattern match fails
                $extractedValues[$key] = '';
            }
        }

        if ($type === 'back' && isset($extractedValues['ডাকঘর'])) {
            $dakghorValue = $extractedValues['ডাকঘর'];
            try {
                $parts = preg_split('/,|-/', $dakghorValue);
                $postOffice = isset($parts[0]) ? trim($parts[0]) : '';
                $postcode = isset($parts[1]) ? trim($parts[1]) : '';
                $thana = isset($parts[2]) ? trim($parts[2]) : '';
                $district = isset($parts[3]) ? trim($parts[3]) : '';
            } catch (\Exception $e) {
                $postOffice = '';
                $postcode = '';
                $thana = '';
                $district = '';
            }
            $extractedValues['ডাকঘর'] = $postOffice;
            $extractedValues['পোস্টকোড'] = $postcode;
            $extractedValues['থানা'] = $thana;
            $extractedValues['জেলা'] = $district;
        }

        // Return extracted values
        return $extractedValues;
    }




}
