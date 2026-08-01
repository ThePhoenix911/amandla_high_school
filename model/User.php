<?php

class User {
    public function __construct(
//        private Int $userId = 0,
        private String $userEmail = '',
        private String $userPassword = '',
    ) {}

//    public function getUserId(): int {return $this->userId;}
    public function getUserEmail(): string {return $this->userEmail;}
    public function getUserPassword(): string {return $this->userPassword;}




}


?>