    <?php

    class Admin {
        public function __construct(
//            private Int $adminID = 0,
            private String $adminFName = '',
            private String $adminLName = '',
            private String $adminEmail = '',
            private String $adminPhoneNum = ''
        ){}

        //Getters
//        public function getAdminID(): int {return $this->adminID;}
        public function getAdminFName(): string {return $this->adminFName;}
        public function getAdminLName(): string {return $this->adminLName;}
        public function getAdminEmail(): string {return $this->adminEmail;}
        public function getAdminPhoneNum(): string {return $this->adminPhoneNum;}

        //Setters
        public function setAdminID($adminID): void {$this->adminID = $adminID;}
        public function setAdminFName($adminFName): void {$this->adminFName = $adminFName;}
        public function setAdminLName($adminLName): void {$this->adminLName = $adminLName;}
        public function setAdminEmail($adminEmail): void {$this->adminEmail = $adminEmail;}
        public function setAdminPhoneNum($adminPhoneNum): void {$this->adminPhoneNum = $adminPhoneNum;}
    }

    ?>