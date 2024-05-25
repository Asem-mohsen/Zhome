<?php

namespace App\Http\Services;


class SyncChoices {

    public static function Sync($model , $condition , $newChoices , $ColumnName){

        $arrayOfChoices = $model::where('ProductID' , $condition)->pluck('ID')->toArray();
        
        // Choices to delete
        $choicesToDelete = array_diff($arrayOfChoices , $newChoices);

        // choices to add
        $choicesToAdd = array_diff($newChoices, $arrayOfChoices);

        // Delete the old choices
        if (!empty($choicesToDelete)) {
            $model::where('ProductID', $condition)->whereIn('ID', $choicesToDelete)->delete();
        }
        
        // Add the new choices
        if (!empty($choicesToAdd)) {

            foreach($choicesToAdd as $choice){
                $model::create([
                    'ProductID' => $condition,
                    $ColumnName => $choice
                ]);
            }
        }
    }
}