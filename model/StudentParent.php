<?php

class StudentParent
{
    public function __construct(
        private String $parentID = '',
        private String $parentTitle = '',
        private String $parentFName = '',
        private String $parentLName = '',
        private String $parentEmail = '',
        private String $parentHouse = '',
        private String $parentStreet = '',
        private String $parentCity = '',
        private String $parentPostal = '',
        private String $parentPhone = ''
    ){}

    //Getters
    public function getparentID(): String {return $this->parentID;}
    public function getparentTitle(): String {return $this->parentTitle;}
    public function getparentFName(): string {return $this->parentFName;}
    public function getparentLName(): string {return $this->parentLName;}
    public function getparentEmail(): string {return $this->parentEmail;}
    public function getparentHouse(): string {return $this->parentHouse;}
    public function getparentStreet(): string {return $this->parentStreet;}
    public function getparentCity(): string {return $this->parentCity;}
    public function getparentPostal(): string {return $this->parentPostal;}
    public function getparentPhone(): string {return $this->parentPhone;}



    //Setters
    public function setparentID($parentID): void {$this->parentID = $parentID;}
    public function setparentTitle($parentTitle): void {$this->parentTitle = $parentTitle;}
    public function setparentFName($parentFName): void {$this->parentFName = $parentFName;}
    public function setparentLName($parentLName): void {$this->parentLName = $parentLName;}
    public function setparentEmail($parentEmail): void {$this->parentEmail = $parentEmail;}
    public function setparentHouse($parentHouse): void {$this->parentHouse = $parentHouse;}
    public function setparentStreet($parentStreet): void {$this->parentStreet = $parentStreet;}
    public function setparentCity($parentCity): void {$this->parentCity = $parentCity;}
    public function setparentPostal($parentPostal): void {$this->parentPostal = $parentPostal;}
    public function setparentPhone($parentPhone): void {$this->parentPhone = $parentPhone;}
}