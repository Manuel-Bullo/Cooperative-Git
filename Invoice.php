<?php
    require_once("Company.php");
    require_once("InvoiceRow.php");

    class Invoice {
        private $businessName, $index, $date;
        private $customer, $paymentMethod, $rows = [];

        public function __construct($businessName, $index, $date, $customer, $paymentMethod) {
            $this->setBusinessName($businessName);
            $this->setIndex($index);
            $this->setDate($date);
            $this->setCustomer($customer);
            $this->setPaymentMethod($paymentMethod);
        }

        public function getBusinessName() { return $this->businessName; }
        public function getIndex() { return $this->index; }
        public function getDate() { return $this->date; }
        public function getCustomer() { return $this->customer; }
        public function getPaymentMethod() { return $this->paymentMethod; }
        
        public function getRows() {
            return $this->rows;
        }

        public function getRow($index) {
            if (!is_int($index) || $index < 1 || !isset($this->rows[$index - 1]))
                return NULL;

            return $this->rows[$index - 1];
        }

        public function setBusinessName($businessName) {
            if (is_string($businessName))
                $this->getBusinessName = $businessName;

            return $this;
        }

        public function setIndex($index) {
            if (is_int($index) && $index > 0)
                $this->index = $index;

            return $this;
        }

        public function setDate($date) {
            if ($date instanceof DateTime)
                $this->date = $date;

            return $this;
        }

        public function setCustomer($customer) {
            if ($customer instanceof Company)
                $this->customer = $customer;

            return $this;
        }

        public function setPaymentMethod($paymentMethod) {
            if (is_string($paymentMethod))
                $this->paymentMethod = $paymentMethod;

            return $this;
        }

        public function addRow($product, $amount = 1, $discount = 0) {
            $this->rows[count($this->rows)] = new InvoiceRow($product, $amount, $discount);
        }

        public function removeRow($index = 1) {
            if (is_int($index) && $index > 0 && $index <= count($this->rows)) {
                $product = $this->rows[$index - 1];
                unset($this->rows[$index - 1]);
                $this->rows = array_filter($this->rows);

                return $product;
            }
        }

        public function __toString() {
            return "Invoice {business name: $this->businessName, index: $this->index, date: ".$this->date->format("Y/m/d").", customer: ".$this->customer->getBusinessName().", payment method: $this->paymentMethod}";
        }
    }
?>