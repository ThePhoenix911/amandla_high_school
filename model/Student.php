<?php

class Student
{
    public function __construct(
        private String $parentID = '',
        private String $studentNum = '',
        private String $studentFName = '',
        private String $studentLName = '',
        private String $studentGrade = '',
    ){}

    //Getters
    public function getParentID(): String {return $this->parentID;}
    public function getStudentNum(): String {return $this->studentNum;}
    public function getStudentFName(): string {return $this->studentFName;}
    public function getStudentLName(): string {return $this->studentLName;}
    public function getStudentGrade(): string {return $this->studentGrade;}



    //Setters
    public function setParentID($parentID): void {$this->parentID = $parentID;}
    public function setStudentNum($studentNum): void {$this->studentNum = $studentNum;}
    public function setStudentFName($studentFName): void {$this->studentFName = $studentFName;}
    public function setStudentLName($studentLName): void {$this->studentLName = $studentLName;}
    public function setStudentGrade($studentGrade): void {$this->studentGrade = $studentGrade;}
}