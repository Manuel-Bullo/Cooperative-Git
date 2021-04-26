<?php
    require_once("Invoice.php");

    class Company {
        private $businessName, $vatNumber, $headOfficeAddress;
        private $municipality, $postalCode, $mail;
        private $telephoneNumber, $imageSrc;
        private $invoicesYear = [];

        public function __construct($businessName, $vatNumber, $headOfficeAddress, $municipality, $postalCode, $mail, $telephoneNumber = NULL, $imageSrc = NULL) {
            $this->setBusinessName($businessName);
            $this->setVatNumber($vatNumber);
            $this->setHeadOfficeAddress($headOfficeAddress);
            $this->setMunicipality($municipality);
            $this->setPostalCode($postalCode);
            $this->setMail($mail);
            $this->setTelephoneNumber($telephoneNumber);
            $this->setImageSrc($imageSrc);
        }

        public function getBusinessName() { return $this->businessName; }
        public function getVatNumber() { return $this->vatNumber; }
        public function getHeadOfficeAddress() { return $this->headOfficeAddress; }
        public function getMunicipality() { return $this->municipality; }
        public function getPostalCode() { return $this->postalCode; }
        public function getMail() { return $this->mail; }
        public function getTelephoneNumber() { return $this->telephoneNumber; }
        public function getImageSrc() { return $this->imageSrc; }

        public function getInvoices($year) {
            if (!is_int($year) || !isset($this->invoicesYear[$year]))
                return NULL;

            return $this->invoicesYear[$year];
        }

        public function getInvoice($year, $index) {
            if (!is_int($year) || !is_int($index) || !isset($this->invoicesYear[$year]) || $index <= 0 || $index > count($this->invoicesYear[$year]))
                return NULL;

            return $this->invoicesYear[$year][$index - 1];
        }

        public function setBusinessName($businessName) {
            if (is_string($businessName))
                $this->businessName = $businessName;

            return $this;
        }

        public function setVatNumber($vatNumber) {
            if (is_string($vatNumber))
                $this->vatNumber = $vatNumber;

            return $this;
        }

        public function setHeadOfficeAddress($headOfficeAddress) {
            if (is_string($headOfficeAddress))
                $this->headOfficeAddress = $headOfficeAddress;

            return $this;
        }

        public function setMunicipality($municipality) {
            if (is_string($municipality))
                $this->municipality = $municipality;

            return $this;
        }

        public function setPostalCode($postalCode) {
            if (is_string($postalCode))
                $this->postalCode = $postalCode;

            return $this;
        }

        public function setMail($mail) {
            if (is_string($mail))
                $this->mail = $mail;

            return $this;
        }

        public function setTelephoneNumber($telephoneNumber) {
            if (is_string($telephoneNumber))
                $this->telephoneNumber = $telephoneNumber;

            return $this;
        }

        public function setImageSrc($imageSrc) {
            if (is_string($imageSrc))
                $this->imageSrc = $imageSrc;

            return $this;
        }

        public function addInvoice($date, $customer, $paymentMethod) {
            if (!($date instanceof DateTime))
                return;

            $year = intval($date->format("Y"));
            $qnt = count($this->invoicesYear[$year]);

            $this->invoicesYear[$year][$qnt] = new Invoice($this->businessName, $qnt + 1, $date, $customer, $paymentMethod);
        }

        public function removeInvoice($year, $index) {
            if (!is_int($year) || !is_int($index) ||
                !array_key_exists($year, $this->invoicesYear) ||
                !isset($this->invoicesYear[$year][$index - 1]))
                return NULL;

            $invoice = $this->invoicesYear[$year][$index - 1];
            unset($this->invoicesYear[$year][$index - 1]);
            array_filter($this->invoicesYear[$year]);

            for ($i = $index; i <= count($this->invoicesYear[$year]); $i++)
                $this->invoicesYear[$year][$i]->setIndex($i);

            return $invoice;
        }

        public function addInvoiceRow($year, $index, $product, $amount = 1, $discount = 0) {
            $this->getInvoice($year, $index)->addRow($product, $amount, $discount);
        }

        public function __toString() {
            return "Company {business name: $this->businessName, vat number: $this->vatNumber, 
                address: $this->address, municipality: $this->municipality, 
                postal code: $this->postalCode, mail: $this->mail, 
                tel number: ".($this->telephoneNumber ?? "NULL").", image source: 
                ".($this->imageSrc ?? "NULL")."}";
        }
    }
?>