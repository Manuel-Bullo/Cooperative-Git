<?php
    require_once("Product.php");

    class InvoiceRow {
        private $product, $qnt, $discount;

        public function __construct($product, $qnt = 1, $discount = 0) {
            $this->setProduct($product);
            $this->setQnt($qnt);
            $this->setDiscount($discount);
        }

        public function getCode() { return $this->product->getCode(); }
        public function getInfo() { return $this->product->getInfo(); }
        public function getVat() { return $this->product->getVat(); }
        public function getPrice() { return $this->product->getPrice(); }
        public function getProduct() { return $this->product; }
        public function getQnt() { return $this->qnt; }
        public function getDiscount() { return $this->discount; }

        public function setProduct($product) {
            if ($product instanceof Product)
                $this->product = $product;

            return $this;
        }

        public function setQnt($qnt) {
            if (is_int($qnt) && $qnt > 0)
                $this->qnt = $qnt;
            
            return $this;
        }

        public function setDiscount($discount) {
            if (is_numeric($discount) && $discount >= 0 && $discount <= 100)
                $this->discount = $discount;

            return $this;
        }

        public function __toString() {
            return "InvoiceRow {product: $this->product, qnt: $this->qnt, discount: $this->discount}";
        }
    }
?>