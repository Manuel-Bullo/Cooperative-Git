<?php
    require_once("Company.php");
    require_once("Product.php");

    $company = new Company("Alfa", "ab454f", "??", "Arezzo", "52100", "mail@gmail.com", "1234567890", "logo.png");
    $product = new Product("aeaeae", "nintendo DS", 22, 44);
    $product2 = new Product("3ft52a", "laptop", 15, 400);
    $product3 = new Product("768de4", "golden fish", 10, 25);
    $product4 = new Product("f4f4f4", "sushi", 2, 14.99);
    $product5 = new Product("43deff", "raspberry PI", 21, 23.44);
    $product6 = new Product("23ef4a", "core", 22, 1864);
    $customer = new Company("New Comp", "f454ba", "??", "Arezzo", "52100", "mail2@gmail.com", "0987654321");
    $date = new DateTime("2021-12-01");
    $year = intval($date->format("Y"));
    $index = 1;

    $company->addInvoice($date, $customer, "credit card");
    $company->addInvoiceRow($year, $index, $product, 3, 10);
    $company->addInvoiceRow($year, $index, $product2, 4);
    $company->addInvoiceRow($year, $index, $product3, 2, 16);
    $company->addInvoiceRow($year, $index, $product4, 10, 4);
    $company->addInvoiceRow($year, $index, $product5, 13, 85);
    $company->addInvoiceRow($year, $index, $product6, 1, 67);
?>

<!DOCTYPE html>

<html>
    <head>
        <link rel="stylesheet" href="styles.css">

        <title>Invoice</title>
    </head>

    <body>
        <div id="invoice-body">
            <div id="header">
                <?php
                    echo "<img src='".$company->getImageSrc()."' id='logo'>";

                    echo "<h1 class='logo'>".$company->getBusinessName()."</h1>";
                ?>
            </div>

            <div id="actors-box">
                <div id="vendor-box" class="p-margin-left">
                    <h3 class="label">Vendor</h3>

                    <div class="box-colors text-left">
                        <p>business name: <?=$company->getBusinessName()?></p>
                        <p>VAT number: <?=$company->getVatNumber()?></p>
                        <p>postal code: <?=$company->getPostalCode()?></p>
                        <p>mail: <?=$company->getMail()?></p>
                        <p>tel. number: <?=$company->getTelephoneNumber()?></p>
                        <p>headOfficeAddress: <?=$company->getHeadOfficeAddress()?></p>
                    </div>

                    <div id="invoice-info" class="text-center">
                        <div id="year-box">
                            <p class="label-small">date</p>

                            <div id="year" class="text-center text-color-white box-colors">
                                <p class="center"><?=$date->format("Y/m/d")?></p>
                            </div>
                        </div>

                        <div id="index-box" class="text-center">
                            <p class="label-small">index</p>

                            <div id="index" class="text-center text-color-white box-colors">
                                <p class="center"><?=$index?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="customer-box" class="p-margin-left">
                    <h3 class="label">Customer</h3>

                    <div class="box-colors text-left">
                        <p>business name: <?=$customer->getBusinessName()?></p>
                        <p>VAT number: <?=$customer->getVatNumber()?></p>
                        <p>postal code: <?=$customer->getPostalCode()?></p>
                        <p>mail: <?=$customer->getMail()?></p>
                        <p>tel. number: <?=$customer->getTelephoneNumber()?></p>
                        <p>headOfficeAddress: <?=$customer->getHeadOfficeAddress()?></p>
                    </div>
                </div>
            </div>

            <table>
                <tr>
                    <th>Prod. code</th>
                    <th>Info</th>
                    <th>Qnt.</th>
                    <th>Unit price</th>
                    <th>Disc.</th>
                    <th>Amount</th>
                    <th>VAT</th>
                </tr>

                <?php
                    $invoice = $company->getInvoice($year, $index);

                    foreach ($invoice->getRows() as $row) {
                        echo "<tr>";

                        echo "<td>".$row->getCode()."</td>";
                        echo "<td>".$row->getInfo()."</td>";
                        echo "<td>".$row->getQnt()."</td>";
                        echo "<td>".$row->getPrice()."</td>";
                        echo "<td>".$row->getDiscount()."</td>";
                        echo "<td>".(($row->getPrice() - ($row->getPrice() * $row->getDiscount() / 100)) * $row->getQnt())."</td>";
                        echo "<td>".$row->getVat()."</td>";

                        echo "</tr>";
                    }
                ?>

                <tr class="text-right">
                    <td colspan="5">Taxable</td>

                    <td>
                        <?php
                            $taxable = 0;

                            foreach ($invoice->getRows() as $row)
                                $taxable += ($row->getPrice() - ($row->getPrice() * $row->getDiscount() / 100)) * $row->getQnt();

                            echo $taxable;
                        ?>
                    </td>

                    <td rowspan="3"></td>
                </tr>

                <tr class="text-right">
                    <td colspan="5">VAT amount</td>

                    <td>
                        <?php
                            $vatAmount = 0;

                            foreach ($invoice->getRows() as $row)
                                $vatAmount += ($row->getPrice() - ($row->getPrice() * $row->getDiscount() / 100)) * $row->getQnt() * $row->getVat() / 100;

                            echo $vatAmount;
                        ?>
                    </td>
                </tr>

                <tr class="text-right">
                    <td colspan="5">TOTAL INVOICE</td>

                    <td class="bg-grey">
                        <?php
                            $tot = 0;

                            foreach ($invoice->getRows() as $row) {
                                $tot += ($row->getPrice() - ($row->getPrice() * $row->getDiscount() / 100)) * $row->getQnt();
                                $tot += ($row->getPrice() - ($row->getPrice() * $row->getDiscount() / 100)) * $row->getQnt() * $row->getVat() / 100;
                            }

                            echo $tot;
                        ?>
                    </td>
                </tr>
            </table>

            <h3>Payment Method: <?=$company->getInvoice($year, $index)->getPaymentMethod()?></h3>
        </div>
    </body>
</html>