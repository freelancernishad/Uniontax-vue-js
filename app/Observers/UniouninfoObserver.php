<?php

namespace App\Observers;

use App\Models\Uniouninfo;
use Illuminate\Support\Facades\Cache;

class UniouninfoObserver
{


    private function clearCache(){

        $allunons = Uniouninfo::select(['short_name_e'])->get();

        foreach ($allunons as $value) {
            $key = 'uniounDetials-'.$value->short_name_e;
            if(Cache::has($key)){
                Cache::forget($key);
            }
        }



    }



    /**
     * Handle the Uniouninfo "created" event.
     *
     * @param  \App\Models\Uniouninfo  $uniouninfo
     * @return void
     */
    public function created(Uniouninfo $uniouninfo)
    {
       $this->clearCache();
    }

    /**
     * Handle the Uniouninfo "updated" event.
     *
     * @param  \App\Models\Uniouninfo  $uniouninfo
     * @return void
     */
    public function updated(Uniouninfo $uniouninfo)
    {
        $this->clearCache();
    }

    /**
     * Handle the Uniouninfo "deleted" event.
     *
     * @param  \App\Models\Uniouninfo  $uniouninfo
     * @return void
     */
    public function deleted(Uniouninfo $uniouninfo)
    {
        $this->clearCache();
    }

    /**
     * Handle the Uniouninfo "restored" event.
     *
     * @param  \App\Models\Uniouninfo  $uniouninfo
     * @return void
     */
    public function restored(Uniouninfo $uniouninfo)
    {
        $this->clearCache();
    }

    /**
     * Handle the Uniouninfo "force deleted" event.
     *
     * @param  \App\Models\Uniouninfo  $uniouninfo
     * @return void
     */
    public function forceDeleted(Uniouninfo $uniouninfo)
    {
        $this->clearCache();
    }
}
