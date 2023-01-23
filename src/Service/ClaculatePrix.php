<?php
namespace App\Service;


class ClaculatePrix
{
    private $range=[
        1=>["min"=>0,"max"=>30],
        2=>["min"=>31,"max"=>100],
        3=>["min"=>101,"max"=>300],
        4=>["min"=>301,"max"=>600],
        5=>["min"=>601,"max"=>1200],
        6=>["min"=>1201,"max"=>2000],
        7=>["min"=>2001,"max"=>3000],
        8=>["min"=>3001,"max"=>100000]
    ];
    private $rationMasseVolu = 5000;
    public function findPrices($klm,$poidColis,$longueurColis,$largeurColis,$hauterColis,$prixRepository,$zonelivRepository)
    {
        $zoneSelected = null;
        foreach($this->range as $ind=>$val){
            if(($klm >= $val["min"]) && ($klm <= $val["max"])){
                $zoneSelected = $ind;
                break;
            }
        }
        if($zoneSelected == null){
            $zoneSelected = 8;
        }
        $poindsTotal = 0;
        foreach($poidColis as $ind2=>$val2){
             $poindsTotal += $this->CalculatePoidsVolumique($val2,$longueurColis[$ind2],$largeurColis[$ind2],$hauterColis[$ind2]);   
        }
        $zone=$zonelivRepository->find($zoneSelected);
        $listPrices = $prixRepository->findBy(["zone"=>$zone]);
        $listLivPrices = [];
        foreach($listPrices as $ind=>$val){
            $listLivPrices[] = [
                "id" => $val->getLivreur()->getId(),
                "nom" => $val->getLivreur()->getNom(),
                "prixTotal" => $poindsTotal * $val->getPrixht()
            ];
        }
        return $listLivPrices;
    }


    private function CalculatePoidsVolumique($poid,$longueur,$largeur,$hauteur){

        $volume = $longueur*$largeur*$hauteur;
        $MasseVolu = $volume / $this->rationMasseVolu;
        if($MasseVolu > $poid){
            return $MasseVolu;
        }else{
            return $poid;
        }

    }   
}