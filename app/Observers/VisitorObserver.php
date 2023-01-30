<?php

namespace App\Observers;

use App\Models\Visitor;
use App\Models\Uniouninfo;
use Illuminate\Support\Facades\Cache;

class VisitorObserver
{



    private function clearCache(){

        $allunons = Uniouninfo::select(['short_name_e'])->get();

        foreach ($allunons as $value) {
            $key = 'visitor-'.$value->short_name_e;
            if(Cache::has($key)){
                Cache::forget($key);
            }
        }



    }




    /**
     * Handle the Visitor "created" event.
     *
     * @param  \App\Models\Visitor  $visitor
     * @return void
     */
    public function created(Visitor $visitor)
    {
        $this->clearCache();
    }

    /**
     * Handle the Visitor "updated" event.
     *
     * @param  \App\Models\Visitor  $visitor
     * @return void
     */
    public function updated(Visitor $visitor)
    {
        $this->clearCache();
    }

    /**
     * Handle the Visitor "deleted" event.
     *
     * @param  \App\Models\Visitor  $visitor
     * @return void
     */
    public function deleted(Visitor $visitor)
    {
        $this->clearCache();
    }

    /**
     * Handle the Visitor "restored" event.
     *
     * @param  \App\Models\Visitor  $visitor
     * @return void
     */
    public function restored(Visitor $visitor)
    {
        $this->clearCache();
    }

    /**
     * Handle the Visitor "force deleted" event.
     *
     * @param  \App\Models\Visitor  $visitor
     * @return void
     */
    public function forceDeleted(Visitor $visitor)
    {
        $this->clearCache();
    }
}
