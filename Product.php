<?php
    class Product {
        private $code, $info, $vat, $price;

        public function __construct($code, $info, $vat, $price) {
            $this->setCode($code);
            $this->setInfo($info);
            $this->setVat($vat);
            $this->setPrice($price);
        }

        public function getCode() { return $this->code; }
        public function getInfo() { return $this->info; }
        public function getVat() { return $this->vat; }
        public function getPrice() { return $this->price; }

        public function setCode($code) {
            if (is_string($code))
                $this->code = $code;

            return $this;
        }

        public function setInfo($info) {
            if (is_string($info))
                $this->info = $info;

            return $this;
        }

        public function setVat($vat) {
            if (is_numeric($vat))
                $this->vat = $vat;

            return $this;
        }

        public function setPrice($price) {
            if (is_numeric($price) && $price > 0)
                $this->price = $price;

            return $this;
        }

        public function __toString() {
            return "Product {code: $this->code, info: $this->info, vat: $this->vat, price: $this->price}";
        }
    }
?>