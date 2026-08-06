<?php include 'includes/header.php'; ?>

<style>
    input.pe-2 {
        margin-right: 5px;
        position: relative;
        top: 2px;
    }
</style>

<div id="content" class="app-content">

    <div class="d-lg-flex align-items-end mb-4">
        <h3 class="page-header mb-lg-0">
            Form Listing
        </h3>
    </div>

    <div class="card p-4">

        <!--ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Company Profile</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Sale Transactions</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Purchase Transactions</button>
            </li> 
        </ul-->

        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
             
                <table class="table">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">S.no</th>
                            <th scope="col">Company Name</th>
                            <th scope="col">Address</th>
                            <th scope="col">Town / City</th>
                            <th scope="col">County</th>
                            <th scope="col">Postcode</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Acme Corp</td>
                            <td>123 Elm Street</td>
                            <td>New York</td>
                            <td>New York County</td>
                            <td>10001</td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>Tech Solutions</td>
                            <td>456 Maple Avenue</td>
                            <td>San Francisco</td>
                            <td>San Francisco County</td>
                            <td>94102</td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td>Innovate Ltd.</td>
                            <td>789 Oak Drive</td>
                            <td>Los Angeles</td>
                            <td>Los Angeles County</td>
                            <td>90012</td>
                        </tr>
                        <tr>
                            <th scope="row">4</th>
                            <td>FutureTech</td>
                            <td>101 Pine Street</td>
                            <td>Chicago</td>
                            <td>Cook County</td>
                            <td>60601</td>
                        </tr>
                        <tr>
                            <th scope="row">5</th>
                            <td>Alpha Corp</td>
                            <td>202 Cedar Avenue</td>
                            <td>Houston</td>
                            <td>Harris County</td>
                            <td>77002</td>
                        </tr>
                        <tr>
                            <th scope="row">6</th>
                            <td>Beta Enterprises</td>
                            <td>303 Birch Lane</td>
                            <td>Phoenix</td>
                            <td>Maricopa County</td>
                            <td>85001</td>
                        </tr>
                        <tr>
                            <th scope="row">7</th>
                            <td>Gamma Industries</td>
                            <td>404 Spruce Road</td>
                            <td>Philadelphia</td>
                            <td>Philadelphia County</td>
                            <td>19102</td>
                        </tr>
                        <tr>
                            <th scope="row">8</th>
                            <td>Delta Solutions</td>
                            <td>505 Redwood Blvd</td>
                            <td>San Diego</td>
                            <td>San Diego County</td>
                            <td>92101</td>
                        </tr>
                        <tr>
                            <th scope="row">9</th>
                            <td>Epsilon Ltd.</td>
                            <td>606 Fir Circle</td>
                            <td>Dallas</td>
                            <td>Dallas County</td>
                            <td>75201</td>
                        </tr>
                        <tr>
                            <th scope="row">10</th>
                            <td>Zeta Group</td>
                            <td>707 Palm Avenue</td>
                            <td>San Antonio</td>
                            <td>Bexar County</td>
                            <td>78205</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                <h3 class="mb-4 mt-2">Property Legal Fees Form</h3>
                <table class="table">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">S.no</th>
                            <th scope="col">Legal fee</th>
                            <th scope="col">Leasehold Fee</th>
                            <th scope="col">Mortgage Admin Fee</th>
                            <th scope="col">Telegraphic Transfer (TT) Fee</th>
                            <th scope="col">Official Copies</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>$500</td>
                            <td>$200</td>
                            <td>$150</td>
                            <td>$50</td>
                            <td>$30</td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>$600</td>
                            <td>$250</td>
                            <td>$180</td>
                            <td>$60</td>
                            <td>$40</td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td>$550</td>
                            <td>$220</td>
                            <td>$160</td>
                            <td>$55</td>
                            <td>$35</td>
                        </tr>
                        <tr>
                            <th scope="row">4</th>
                            <td>$700</td>
                            <td>$300</td>
                            <td>$200</td>
                            <td>$70</td>
                            <td>$50</td>
                        </tr>
                        <tr>
                            <th scope="row">5</th>
                            <td>$750</td>
                            <td>$320</td>
                            <td>$210</td>
                            <td>$75</td>
                            <td>$55</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab" tabindex="0">
                <h3 class="mb-4 mt-2">Additional Services</h3>
                <table class="table">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">S.no</th>
                            <th scope="col">Service</th>
                            <th scope="col">Description</th>
                            <th scope="col">Cost</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Survey</td>
                            <td>Full property survey</td>
                            <td>$400</td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>Valuation</td>
                            <td>Market valuation report</td>
                            <td>$300</td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td>Legal Advice</td>
                            <td>Consultation with a lawyer</td>
                            <td>$200</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


    </div>

    <?php include 'includes/footer.php'; ?>