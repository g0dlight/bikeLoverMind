<?php

class OrelBrain extends NormalBrain
{
    protected $bikes = ['CBR650F'];

    public function be(callable $additionalBehaviour=NULL)
    {
        /**
         * Recursive function
         * Will take care of normal life (work, eat, ride, sleep, etc.)
         */
        parent::be(function() use ($additionalBehaviour)
        {
            if( $additionalBehaviour )
                call_user_func( $additionalBehaviour );

            while( ! $this->canAffordNextLevelBike() ){
                $this->dieALittleBit();

                $this->compute('replaceYourJob')->isItProfitable()->IsItPossible()->doIt();

                $this->compute('replaceLivingCity')->isItProfitable()->IsItPossible()->doIt();
            }

            $this->bikes[] = $this->buy('NextLevelBike'); // WARNING will cause happinessPercent = ceil(1e+36)

            $this->ride( end( $this->bikes ) ); // Will return $this->happinessPercent to normal value (100);
        });
    }

    protected function canAffordNextLevelBike()
    {
        reset($this->bikes);

        $this->savings += $this->income - $this->outcome;

        $remnant = $this->savings - $this->getPrice('NextLevelBike');

        $needToSale = [];

        do{
            if( $remnant >= 0 ) {
                $this->sale($needToSale);

                return TRUE;
            }

            if( $needToSale[] = current($this->bikes) )
                $remnant += $this->getPrice( end($needToSale) );

        }while( next($this->bikes) || count($this->bikes) == count($needToSale) );

        return FALSE;
    }

    protected function dieALittleBit()
    {
        $this->happinessPercent -= 0.000000000000000001;
    }
}

// running since December 17, 1989
$orelBrain = new OrelBrain();

$orelBrain->be();
