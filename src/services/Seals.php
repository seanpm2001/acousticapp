<?php
/**
 * Acoustic App plugin for Craft CMS 3.x
 *
 * Acoustic App @asclearasmud
 *
 * @link      http://ournameismud.co.uk/
 * @copyright Copyright (c) 2018 @asclearasmud
 */

namespace ournameismud\acousticapp\services;

use ournameismud\acousticapp\AcousticApp;
use ournameismud\acousticapp\records\Seals AS SealRecord;
use ournameismud\acousticapp\records\TestsSeals AS TestsSealsRecord;

use Craft;
use craft\base\Component;

/**
 * @author    @asclearasmud
 * @package   AcousticApp
 * @since     1.0.0
 */
class Seals extends Component
{
    // Public Methods
    // =========================================================================

    // Name: getSealsByTest
    // Purpose: service to fetch seals for a specific test
    // Required: $id (integer)
    // Optional: none
    // Services: 
    //      getSeals
    
    public function getSealsByTest( int $id )
    {
        $seals = $this->getSeals( ['testId' => $id] );
        return $seals;   
    }

    // Name: getSeals
    // Purpose: service to fetch seals based on defined criteria
    // Required: none
    // Optional: $criteria (array or object)
    // Records: 
    //      TestsSeals
    //      Seals

    public function getSeals( $criteria = null )
    {
        $TestsSeals = TestsSealsRecord::find()->where( $criteria )->all();
        $seals = [];
        foreach ($TestsSeals AS $TestsSeal) {
            if (!array_key_exists($TestsSeal->context, $seals)) $seals[$TestsSeal->context] = [];
            $seal = SealRecord::find()->where( ['id' => $TestsSeal->sealId] )->one();
            $seals[$TestsSeal->context][$seal->sealCode] = $TestsSeal->quantity;
        }
        return $seals;
    }
}
