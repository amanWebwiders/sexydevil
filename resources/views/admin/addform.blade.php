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
            Add Form
        </h3>
    </div>

    <div class="card p-4">
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Company Profile</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Sale Transactions</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Purchase Transactions</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#tab-4" type="button" role="tab" aria-controls="tab-4" aria-selected="false">Lendor Panels</button>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                <h3 class="mt-2 mb-4">Main Office</h3>
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <label class="form-label">Company Name</label>
                        <input type="text" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-4">
                        <label class="form-label">Address</label>
                        <input type="text" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-4">
                        <label class="form-label">Town / City</label>
                        <input type="text" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-4">
                        <label class="form-label">County</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="col-md-4 mb-4">
                        <label class="form-label">Postcode</label>
                        <input type="text" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-4">
                        <label class="form-label">Company Website</label>
                        <input type="url" class="form-control">
                    </div>
                    <div class="col-md-4 mb-4">
                        <label class="form-label">Company Email</label>
                        <input type="email" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-4">
                        <label class="form-label">Company Telephone Number</label>
                        <input type="tel" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-4">
                        <label class="form-label">Company Primary Contact Person</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="col-md-4 mb-4">
                        <label class="form-label">Primary Contact Email</label>
                        <input type="email" class="form-control">
                    </div>
                    <div class="col-md-4 mb-4">
                        <label class="form-label">Primary Contact Telephone Number</label>
                        <input type="tel" class="form-control">
                    </div>
                    <div class="col-md-4 mb-4">
                        <label class="form-label">Accounts Contact Person</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="col-md-4 mb-4">
                        <label class="form-label">Accounts Contact Email</label>
                        <input type="email" class="form-control">
                    </div>
                    <div class="col-md-4 mb-4">
                        <label class="form-label">Accounts Contact Telephone Number</label>
                        <input type="tel" class="form-control">
                    </div>
                    <div class="col-md-4 mb-4">
                        <label class="form-label">Registered Company? - If so, provide your number</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="col-md-4 mb-4">
                        <label class="form-label">SRA Number - Applicable to Solicitors ONLY</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="col-md-4 mb-4">
                        <label class="form-label">CQS Accredited? - Please provide your number</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="col-md-4 mb-4">
                        <label class="form-label">Lexcel Certified?</label>
                        <div>
                            <input type="radio" name="lexcel" value="yes"><span class="ms-2 me-3">Yes</span>
                            <input type="radio" name="lexcel" value="no"><span class="ms-2 me-3">No</span>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <label class="form-label">CLC Number - Applicable to Licensed Conveyancers ONLY</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="col-md-4 mb-4">
                        <label class="form-label">VAT Number - If applicable</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="col-md-4 mb-4">
                        <label class="form-label">Law Society Member? - Please provide your number</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="col-md-4 mb-4">
                        <label class="form-label">Do you offer online case tracking?</label>
                        <div>
                            <input type="radio" name="case_tracking" value="yes"><span class="ms-2 me-3">Yes</span>
                            <input type="radio" name="case_tracking" value="no"><span class="ms-2 me-3">No</span>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <label class="form-label">Do you offer no sale, no fee transactions?</label>
                        <div>
                            <input type="radio" name="no_sale_no_fee" value="yes"><span class="ms-2 me-3">Yes</span>
                            <input type="radio" name="no_sale_no_fee" value="no"><span class="ms-2 me-3">No</span>
                        </div>
                    </div>
                </div>
                <div class="text-end">
                    <a href="#" class="btn ms-auto mt-3">Submit</a>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                <h3 class="mb-4 mt-2">Property Legal Fees Form</h3>
                <h5>Property Value / Price</h5>
                <div class="row mb-5">
                    <div class="col-md-4 mb-4">
                        <label class="form-label">From</label>
                        <select class="form-select">
                            <option value="0">£0</option>
                            <option value="80001">£80,001</option>
                            <option value="101001">£101,001</option>
                            <option value="150001">£150,001</option>
                            <option value="201001">£201,001</option>
                            <option value="250001">£250,001</option>
                            <option value="300001">£300,001</option>
                            <option value="400001">£400,001</option>
                            <option value="500001">£500,001</option>
                            <option value="600001">£600,001</option>
                            <option value="750001">£750,001</option>
                            <option value="900001">£900,001</option>
                            <option value="1000001">£1,000,001</option>
                            <option value="3000001">£3,000,001</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-4">
                        <label class="form-label">To</label>
                        <select class="form-select">
                            <option value="80000">£80,000</option>
                            <option value="100000">£100,000</option>
                            <option value="150000">£150,000</option>
                            <option value="200000">£200,000</option>
                            <option value="250000">£250,000</option>
                            <option value="300000">£300,000</option>
                            <option value="400000">£400,000</option>
                            <option value="500000">£500,000</option>
                            <option value="600000">£600,000</option>
                            <option value="750000">£750,000</option>
                            <option value="900000">£900,000</option>
                            <option value="1000000">£1,000,000</option>
                            <option value="2000000">£2,000,000</option>
                            <option value="3000000">£3,000,000</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-4">
                        <label class="form-label">Legal Fee (excl VAT)</label>
                        <input type="text" class="form-control">
                    </div>
                </div>

                <h5>Fixed Fees (VAT Applies)</h5>
                <div class="row mb-5">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Leasehold Fee</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Mortgage Admin Fee</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Telegraphic Transfer (TT) Fee</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Shared Ownership Fee</label>
                        <input type="text" class="form-control">
                    </div>
                </div>

                <h5>Sale Disbursements (VAT Inclusive Figure)</h5>
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <label class="form-label">Identity Check</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="col-md-4 mb-4">
                        <label class="form-label">Anti Money Laundering Search</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="col-md-4 mb-4">
                        <label class="form-label">Official Copies</label>
                        <input type="text" class="form-control">
                    </div>
                </div>
                <div class="text-end">
                    <a href="#" class="btn ms-auto mt-3">Submit</a>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab" tabindex="0">
                <h3 class="mt-2 mb-4">Purchase Transactions</h3>
                <div class="row">
                    <h5>Property Value / Price</h5>
                    <div class="col-md-4 mb-4">
                        <label for="from" class="form-label">From</label>
                        <select id="from" class="form-select">
                            <option value="80000">£80,000</option>
                            <option value="100000">£100,000</option>
                            <option value="150000">£150,000</option>
                            <option value="200000">£200,000</option>
                            <option value="250000">£250,000</option>
                            <option value="300000">£300,000</option>
                            <option value="400000">£400,000</option>
                            <option value="500000">£500,000</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-4">
                        <label for="to" class="form-label">To</label>
                        <select id="to" class="form-select">
                            <option value="100000">£100,000</option>
                            <option value="150000">£150,000</option>
                            <option value="200000">£200,000</option>
                            <option value="250000">£250,000</option>
                            <option value="300000">£300,000</option>
                            <option value="400000">£400,000</option>
                            <option value="500000">£500,000</option>
                            <option value="1000000">£1,000,000</option>
                        </select>
                    </div>

                    <!-- Legal Fees -->
                    <h5>Fixed Fees</h5>
                    <div class="col-md-4 mb-4">
                        <label for="legalFee" class="form-label">Legal Fee (Excl. VAT)</label>
                        <input type="text" id="legalFee" class="form-control">
                    </div>

                    <!-- HM Land Registry Fee -->
                    <h5> HM Land Registry Fee</h5>
                    <div class="col-md-4 mb-4">
                        <label for="hmLandRegistry" class="form-label">HM Land Registry Fee</label>
                        <select name="" id="" class="form-select">
                            <option value="20.00">20.00</option>
                            <option value="40.00">40.00</option>
                            <option value="95.00">95.00</option>
                            <option value="95.00">95.00</option>
                            <option value="135.00">135.00</option>
                            <option value="135.00">135.00</option>
                            <option value="135.00">135.00</option>
                            <option value="135.00">135.00</option>
                            <option value="135.00">135.00</option>
                            <option value="270.00">270.00</option>
                            <option value="270.00">270.00</option>
                            <option value="270.00">270.00</option>
                            <option value="270.00">270.00</option>
                            <option value="270.00">270.00</option>
                            <option value="270.00">270.00</option>
                            <option value="270.00">270.00</option>
                            <option value="270.00">270.00</option>
                            <option value="270.00">270.00</option>
                            <option value="270.00">270.00</option>
                            <option value="270.00">270.00</option>
                            <option value="455.00">455.00</option>
                            <option value="455.00">455.00</option>

                        </select>
                    </div>

                    <!-- Fixed Fees -->
                    <div class="col-md-4 mb-4">
                        <label for="mortgageAdmin" class="form-label">Mortgage Admin Fee</label>
                        <input type="text" id="mortgageAdmin" class="form-control">
                    </div>

                    <div class="col-md-4 mb-4">
                        <label class="form-label">Telegraphic Transfer</label>
                        <div>
                            <input type="radio" name="telegraphic" value="yes"><span class="ms-2 me-3">Yes</span>
                            <input type="radio" name="telegraphic" value="no"><span class="ms-2 me-3">No</span>
                        </div>
                    </div>

                    <div class="col-md-4 mb-4">
                        <label for="mortgageAdmin" class="form-label">Help to Buy ISA Fee</label>
                        <input type="text" id="mortgageAdmin" class="form-control">
                    </div>
                    <div class="col-md-4 mb-4">
                        <label for="mortgageAdmin" class="form-label">Help To Buy Fee</label>
                        <input type="text" id="mortgageAdmin" class="form-control">
                    </div>
                    <div class="col-md-4 mb-4">
                        <label for="mortgageAdmin" class="form-label">Right to Buy Fee</label>
                        <input type="text" id="mortgageAdmin" class="form-control">
                    </div>
                    <div class="col-md-4 mb-4">
                        <label for="mortgageAdmin" class="form-label">Shared Ownership Fee</label>
                        <input type="text" id="mortgageAdmin" class="form-control">
                    </div>
                    <div class="col-md-4 mb-4">
                        <label for="mortgageAdmin" class="form-label">Newbuild Fee</label>
                        <input type="text" id="mortgageAdmin" class="form-control">
                    </div>
                    <div class="col-md-4 mb-4">
                        <label for="mortgageAdmin" class="form-label">Islamic Mortgage Fee</label>
                        <input type="text" id="mortgageAdmin" class="form-control">
                    </div>
                    <div class="col-md-4 mb-4">
                        <label for="mortgageAdmin" class="form-label">Auction / Repossession Fee</label>
                        <input type="text" id="mortgageAdmin" class="form-control">
                    </div>
                    <div class="col-md-4 mb-4">
                        <label for="mortgageAdmin" class="form-label">Gifted Deposit Fee</label>
                        <input type="text" id="mortgageAdmin" class="form-control">
                    </div>
                    <div class="col-md-4 mb-4">
                        <label for="mortgageAdmin" class="form-label">Buy to Let Fee</label>
                        <input type="text" id="mortgageAdmin" class="form-control">
                    </div>

                    <!-- Leasehold Fee -->
                    <div class="col-md-4 mb-4">
                        <label class="form-label">Leasehold Fee</label>
                        <div>
                            <input type="radio" name="leasehold" value="yes"><span class="ms-2 me-3">Yes</span>
                            <input type="radio" name="leasehold" value="no"><span class="ms-2 me-3">No</span>
                        </div>
                    </div>

                    <!-- Other Fees -->
                    <div class="col-md-4 mb-4">
                        <label for="landRegistrySearch" class="form-label">Land Registry Search</label>
                        <input type="text" id="landRegistrySearch" class="form-control">
                    </div>

                    <div class="col-md-4 mb-4">
                        <label for="searchPack" class="form-label">Search Pack - Local Authority, Water & Drainage</label>
                        <input type="text" id="searchPack" class="form-control">
                    </div>
                </div>
                <div class="text-end">
                    <a href="#" class="btn ms-auto mt-3">Submit</a>
                </div>
            </div>

            <div class="tab-pane fade" id="tab-4" role="tabpanel" aria-labelledby="tab-4-tab" tabindex="0">
                <h3 class="mt-2 mb-4">Lendor Panels</h3>
                <div class="row">
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank1" name="bank" value="Accord Mortgages" class="pe-2"><label for="bank1">Accord Mortgages</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank2" name="bank" value="Aldermore Bank" class="pe-2"><label for="bank2">Aldermore Bank</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank3" name="bank" value="Atom" class="pe-2"><label for="bank3">Atom</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank4" name="bank" value="Bank of China (UK)" class="pe-2"><label for="bank4">Bank of China (UK)</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank5" name="bank" value="Bank of Ireland (UK)" class="pe-2" checked><label for="bank5">Bank of Ireland (UK)</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank6" name="bank" value="Barclays" class="pe-2"><label for="bank6">Barclays</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank7" name="bank" value="Bath Building Society" class="pe-2"><label for="bank7">Bath Building Society</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank8" name="bank" value="Beverley Building Society" class="pe-2"><label for="bank8">Beverley Building Society</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank9" name="bank" value="Bluestone" class="pe-2"><label for="bank9">Bluestone</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank10" name="bank" value="BM Solutions" class="pe-2"><label for="bank10">BM Solutions</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank11" name="bank" value="Buckinghamshire Building Society" class="pe-2"><label for="bank11">Buckinghamshire Building Society</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank12" name="bank" value="BuildLoan" class="pe-2"><label for="bank12">BuildLoan</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank13" name="bank" value="Cambridge Building Society" class="pe-2"><label for="bank13">Cambridge Building Society</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank14" name="bank" value="Chelsea Building Society" class="pe-2"><label for="bank14">Chelsea Building Society</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank15" name="bank" value="Chorley & District Society" class="pe-2"><label for="bank15">Chorley & District Society</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank16" name="bank" value="Clydesdale Bank PLC" class="pe-2"><label for="bank16">Clydesdale Bank PLC</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank17" name="bank" value="Co-operative Bank" class="pe-2"><label for="bank17">Co-operative Bank</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank18" name="bank" value="Coventry Building Society/Godiva" class="pe-2"><label for="bank18">Coventry Building Society/Godiva</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank19" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Darlington Building Society</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank20" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Dudley Building Society</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank21" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Ecology Building Society</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank22" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">First Direct</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank23" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Fleet Mortgages</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank24" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Foundation Home Loans</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank25" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Furness Building Society</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank26" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Halifax</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank27" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Hanley Economic Building Society</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank28" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Hinkley &amp; Rugby Building Society</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank29" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Holmesdale Building Society</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank30" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Holmesdale Building Society</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank31" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">HSBC</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank32" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Ipswich Building Society</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank33" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Kensington Mortgage Company Limited</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank34" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Kent Reliance Bank</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank35" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Landbay</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank36" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Leeds Building Society</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank37" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Leek United Building Society</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank38" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Legal & General</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank39" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Lloyds Bank</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank40" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Loughborough Building Society</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank32" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Market Harborough Building Society</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank32" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Marsden Building Society</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank32" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Masthaven Bank</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank32" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Melton Mowbray Building Society</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank32" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Metro Bank</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank32" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Monmouthshire Building Society</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank32" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Mortgage trust</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank32" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">N & P</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank32" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">National Counties Building Society</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank32" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Nationwide Building Society</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank32" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Natwest Intermediary Solutions</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank32" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Newbury Building Society</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank32" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Newcastle Building Society</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank32" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Paragon Mortgages</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank32" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Platform</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank32" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Post Office</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank32" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Precise Mortgages</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank32" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Principality Building Society</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank32" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Progressive Building Society</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank32" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Royal Bank of Scotland (RBS)</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank32" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Saffron Building Society</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank32" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Santander</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank32" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Scottish Building Society</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank32" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Scottish Widows Bank</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank32" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Shawbrook Bank Limited</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank32" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Skipton Building Society</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank32" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Stafford Railway Building Society</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank32" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Swansea Building Society</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank32" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Teachers Building Society</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank32" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Tesco Bank</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank32" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">TFC Homeloans</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank32" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">The Mortgage Works</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank32" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Tipton Building Society</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank32" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Together</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank32" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">TSB Bank</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank32" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Ulster Bank</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank32" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">United Trust Bank</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank32" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Vernon</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank32" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Vida Homeloans</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank32" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Virgin Money PLC</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank32" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">West Bromwich Building Society</label></div>
                    <div class="col-md-3 col-6 mb-2"><input type="radio" id="bank32" name="bank" value="Darlington Building Society" class="pe-2"><label for="bank19">Yorkshire Building Society</label></div>
                </div>

                <div class="text-end">
                    <a href="#" class="btn ms-auto mt-3">Submit</a>
                </div>

            </div>
        </div>



    </div>

    <?php include 'includes/footer.php'; ?>