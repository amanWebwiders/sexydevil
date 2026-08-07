<?php include './includes/header_login.php'; ?>


<div class="contact-page pt-2 fix mt-5 my_user">
    <div class="contact-page-wrapper style1">
        <div class="container">
            <div class="row justify-content-center mx-0">
                <div class="left">
                    <h4>My Menu</h4>
                    <div class="sidebar">
                        <ul>
                            <li><a href="user.php" class="active">My Form</a></li>
                            <li><a href="edit_profile.php" class="">Edit Profile</a></li>
                            <li><a href="change_password.php" class="">Change Password</a></li>
                        </ul>
                    </div>
                </div>

                <div class="right">
                    <div class="contact-form">
                        <div class="title-section style9 sec-title-animation animation-style2">
                            <div class="title-content">
                                <h2>My Form</h2>
                            </div>
                        </div>
                        <section class="container forms multistep">
                            <div class="form login">
                                <div class="d-flex flex-column">

                                    <div class="wch-card-section style1">
                                        <div class="row">


                                            <h3 class="mb-3">1) Applicant details</h3>
                                            <div class="col-md-6">
                                                <div class="field">
                                                    <label for="">Applicant name(s) (individual or company full name)</label>
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="text">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="field">
                                                    <label for="">Contact name (only applicable for companies)</label>
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="text">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="field">
                                                    <label for="">Postal address (PO Box or street address)</label>
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="date">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="field">
                                                    <label for="">Suburb</label>
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="text">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="field">
                                                    <label for="">State</label>
                                                    <div class="form-floating">
                                                        <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                                                            <option selected>Select State</option>
                                                            <option value="1">One</option>
                                                            <option value="2">Two</option>
                                                            <option value="3">Three</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="field">
                                                    <label for="">Postcode</label>
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="text">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="field">
                                                    <label for="">Country</label>
                                                    <div class="form-floating">
                                                        <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                                                            <option selected>Select Country</option>
                                                            <option value="1">One</option>
                                                            <option value="2">Two</option>
                                                            <option value="3">Three</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="field">
                                                    <label for="">Contact number</label>
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="text">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="field">
                                                    <label for="">Email address (non-mandatory)</label>
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="email">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="field">
                                                    <label for="">Mobile number (non-mandatory)</label>
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="number">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="field">
                                                    <label for="">Fax number (non-mandatory)</label>
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="number">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="field">
                                                    <label for="">Applicant’s reference number(s) (if applicable)</label>
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="number">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row mt-5">

                                            <h3 class="mb-1">2) Location of the premises (complete 2.1 and 2.2 if applicable)</h3>
                                            <p class="mb-3">Note: Provide details below and attach a site plan for any or all premises part of the development application. For further information, see DA Forms Guide: </p>

                                            <h4 class="mt-2 mb-4">2.1) Street address and lot on plan</h4>
                                            <div class="checkbox_div">
                                                <label class="check_div">
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                    <div class="checkmark"></div>
                                                </label>
                                                <span>Street address AND lot on plan (all lots must be listed), or</span>
                                            </div>

                                            <div class="checkbox_div">
                                                <label class="check_div">
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                    <div class="checkmark"></div>
                                                </label>
                                                <span>Street address AND lot on plan for an adjoining or adjacent property of the premises (appropriate for development in water but adjoining or adjacent to land e.g. jetty, pontoon. All lots must be listed).</span>
                                            </div>


                                            <div class="col-md-2">
                                                <div class="field">
                                                    <label for="">Unit No.</label>
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="number">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="field">
                                                    <label for="">Street No.</label>
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="number">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="field">
                                                    <label for="">Street Name</label>
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="text">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="field">
                                                    <label for="">Suburb</label>
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="text">
                                                </div>
                                            </div>


                                            <div class="col-md-2">
                                                <div class="field">
                                                    <label for="">Postcode</label>
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="number">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="field">
                                                    <label for="">Lot No.</label>
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="number">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="field">
                                                    <label for="">Plan type and Number (e.g. RP, SP)</label>
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="text">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="field">
                                                    <label for="">Local Government Area(s)</label>
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="text">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="field">
                                                    <label for="">Site area (m2)</label>
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="text">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="field">
                                                    <label for="">Floor area (m2)</label>
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="text">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="field">
                                                    <label for="">Building classification</label>
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="text">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="field">
                                                    <label for="">Building/structure description</label>
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="text">
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="field">
                                                    <label for="">Description of building work</label>
                                                    <textarea name="" id=""></textarea>
                                                </div>
                                            </div>

                                            <h4 class="mt-2 mb-4">2.2) Additional premises</h4>
                                            <div class="checkbox_div">
                                                <label class="check_div">
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                    <div class="checkmark"></div>
                                                </label>
                                                <span>Additional premises are relevant to this development application and the details of these premises have been attached in a schedule to this development application</span>
                                            </div>
                                            <div class="checkbox_div">
                                                <label class="check_div">
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                    <div class="checkmark"></div>
                                                </label>
                                                <span> Not required</span>
                                            </div>

                                            <h3 class="mb-1 mt-4">3) Are there any existing easements over the premises?</h3>
                                            <p class="mb-3">Note: Easement uses vary throughout Queensland and are to be identified correctly and accurately. For further information on easements and how they may affect the proposed development, see the DA Forms Guide</p>




                                            <div class="checkbox_div">
                                                <label class="check_div">
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                    <div class="checkmark"></div>
                                                </label>
                                                <span>Yes – All easement locations, placeholder="Lorem Ipsum is simply dummy text of the printing "  type s and dimensions are included in plans submitted with this development application</span>
                                            </div>
                                            <div class="checkbox_div">
                                                <label class="check_div">
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                    <div class="checkmark"></div>
                                                </label>
                                                <span>No</span>
                                            </div>




                                        </div>
                                        <div class="row mt-5">

                                            <div class="row mb-4">
                                                <h3 class="mb-3">4) Is the application only for building work assessable against the building assessment provisions?</h3>
                                                <div class="checkbox_div">
                                                    <label class="check_div">
                                                        <input checked="checked" placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                        <div class="checkmark"></div>
                                                    </label>
                                                    <span>Yes proceed to 8)</span>
                                                </div>


                                                <div class="checkbox_div">
                                                    <label class="check_div">
                                                        <input checked="checked" placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                        <div class="checkmark"></div>
                                                    </label>
                                                    <span>No</span>
                                                </div>
                                            </div>

                                            <div class="row mb-4">
                                                <h3 class="mb-3">5) Identify the assessment manager(s) who will be assessing this development application</h3>
                                                <div class="checkbox_div">
                                                    <label class="check_div">
                                                        <input checked="checked" placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                        <div class="checkmark"></div>
                                                    </label>
                                                    <span>Yes</span>
                                                </div>
                                                <div class="checkbox_div">
                                                    <label class="check_div">
                                                        <input checked="checked" placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                        <div class="checkmark"></div>
                                                    </label>
                                                    <span>No</span>
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <h3 class="mb-3">6) Has the local government agreed to apply a superseded planning scheme for this devel</h3>

                                                <div class="checkbox_div">
                                                    <label class="check_div">
                                                        <input checked="checked" placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                        <div class="checkmark"></div>
                                                    </label>
                                                    <span> Yes – a copy of the decision notice is attached to this development application
                                                    </span>
                                                </div>

                                                <div class="checkbox_div">
                                                    <label class="check_div">
                                                        <input checked="checked" placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                        <div class="checkmark"></div>
                                                    </label>
                                                    <span> The local government is taken to have agreed to the superseded planning scheme request – relevant documents attached
                                                    </span>
                                                </div>

                                                <div class="checkbox_div">
                                                    <label class="check_div">
                                                        <input checked="checked" placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                        <div class="checkmark"></div>
                                                    </label>
                                                    <span> No</span>
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <h3 class="mb-3">7) Information request under Part 3 of the DA Rules</h3>
                                                <div class="checkbox_div">
                                                    <label class="check_div">
                                                        <input checked="checked" placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                        <div class="checkmark"></div>
                                                    </label>
                                                    <span> I agree to receive an information request if determined necessary for this development application
                                                    </span>
                                                </div>
                                                <div class="checkbox_div">
                                                    <label class="check_div">
                                                        <input checked="checked" placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                        <div class="checkmark"></div>
                                                    </label>
                                                    <span> I do not agree to accept an information request for this development application
                                                    </span>
                                                </div>
                                                <p> <span><b>Note</b></span> By not agreeing to accept an information request I, the applicant, acknowledge:</p>
                                                <ul class="mb-3">
                                                    <li>that this development application will be assessed and decided based on the information provided when making this development application and the assessment manager and any referral agencies relevant to the development application are not obligated under the DA Rules to accept any additional information provided by the applicant for the development application unless agreed to by the relevant parties.
                                                    </li>
                                                    <li>Part 3 of the DA Rules will still apply if the application is an application listed under section 11.3 of the DA Rules.</li>
                                                </ul>
                                            </div>



                                            <div class="row mb-4">
                                                <h3 class="mb-3">8) Are there any associated development applications or current approvals?</h3>
                                                <div class="checkbox_div">
                                                    <label class="check_div">
                                                        <input checked="checked" placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                        <div class="checkmark"></div>
                                                    </label>
                                                    <span> Yes – provide details below or include details in a schedule to this development application</span>
                                                </div>
                                                <div class="checkbox_div">
                                                    <label class="check_div">
                                                        <input checked="checked" placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                        <div class="checkmark"></div>
                                                    </label>
                                                    <span> No</span>
                                                </div>
                                                <div class="col-md-12">
                                                    <p>List of approval/development application</p>
                                                    <div class="checkbox_div">
                                                        <label class="check_div">
                                                            <input checked="checked" placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                            <div class="checkmark"></div>
                                                        </label>
                                                        <span> No</span>
                                                    </div>
                                                    <div class="checkbox_div">
                                                        <label class="check_div">
                                                            <input checked="checked" placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                            <div class="checkmark"></div>
                                                        </label>
                                                        <span> No</span>
                                                    </div>

                                                </div>
                                                <div class="col-md-4">
                                                    <div class="field">
                                                        <label for="">Reference</label>
                                                        <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="number">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="field">
                                                        <label for="">Date</label>
                                                        <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="text">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="field">
                                                        <label for="">Assessment Manager</label>
                                                        <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="text">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row mb-4">
                                                <h3 class="mb-3 mt-3">9) Has the portable long service leave levy been paid?</h3>
                                                <div class="checkbox_div ">
                                                    <label class="check_div">
                                                        <input checked="checked" placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                        <div class="checkmark"></div>
                                                    </label>
                                                    <span> Yes – a copy of the receipted QLeave form is attached to this development application
                                                    </span>
                                                </div>
                                                <div class="checkbox_div">
                                                    <label class="check_div">
                                                        <input checked="checked" placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                        <div class="checkmark"></div>
                                                    </label>
                                                    <span>No – I, the applicant will provide evidence that the portable long service leave levy has been paid before the assessment manager decides the development application. I acknowledge that the assessment manager may give a development approval only if I provide evidence that the portable long service leave levy has been paid
                                                    </span>
                                                </div>
                                                <div class="checkbox_div">
                                                    <label class="check_div">
                                                        <input checked="checked" placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                        <div class="checkmark"></div>
                                                    </label>
                                                    <span>Not applicable (e.g. building and construction work is less than $150,000 excluding GST)
                                                    </span>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="field">
                                                        <label for="">Amount paid</label>
                                                        <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="text">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="field">
                                                        <label for="">Date paid (dd/mm/yy)</label>
                                                        <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="date">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="field">
                                                        <label for="">QLeave levy number (A, B or E)</label>
                                                        <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="text">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mb-4">
                                                <h3 class="mb-3 mt-3">10) Is this development application in response to a show cause notice or required as a result of an enforcement notice? </h3>
                                                <div class="checkbox_div">
                                                    <label class="check_div">
                                                        <input checked="checked" placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                        <div class="checkmark"></div>
                                                    </label>
                                                    <span> Yes – show cause or enforcement notice is attached </span>
                                                </div>
                                                <div class="checkbox_div">
                                                    <label class="check_div">
                                                        <input checked="checked" placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                        <div class="checkmark"></div>
                                                    </label>
                                                    <span>No</span>
                                                </div>
                                            </div>

                                            <div class="row mb-4">
                                                <h3 class="mb-3">11) Identify any of the following further legislative requirements that apply to any aspect of this development application </h3>
                                                <div class="checkbox_div">
                                                    <label class="check_div">
                                                        <input checked="checked" placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                        <div class="checkmark"></div>
                                                    </label>
                                                    <span>The proposed development is on a place entered in the <b> Queensland Heritage Register</b> or in a <b>local government’s Local Heritage Register.</b> See the guidance provided at www.des.qld.gov.au about the requirements in relation to the development of a Queensland heritage place
                                                    </span>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="field">
                                                        <label for="">Name of the heritage place</label>
                                                        <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="text">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="field">
                                                        <label for="">Place ID</label>
                                                        <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="text">
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                        <div class="row mt-5">
                                            <div class="row mb-3">
                                                <h3 class="mb-3">12) Does this development application include any building work aspects that have any referral requirem</h3>
                                                <div class="checkbox_div">
                                                    <label class="check_div">
                                                        <input checked="checked" placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                        <div class="checkmark"></div>
                                                    </label>
                                                    <span>Yes – the Referral checklist for building work is attached to this development application.</span>
                                                </div>

                                                <div class="checkbox_div">
                                                    <label class="check_div">
                                                        <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                        <div class="checkmark"></div>
                                                    </label>
                                                    <span>No – proceed to Part 5</span>
                                                </div>
                                            </div>


                                            <div class="row mb-3">
                                                <h3 class="mb-3">13) Has any referral agency provided a referral response for this development application?</h3>
                                                <div class="checkbox_div">
                                                    <label class="check_div">
                                                        <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                        <div class="checkmark"></div>
                                                    </label>
                                                    <span> Yes – referral response(s) received and listed below are attached to this development application </span>
                                                </div>

                                                <div class="checkbox_div">
                                                    <label class="check_div">
                                                        <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                        <div class="checkmark"></div>
                                                    </label>
                                                    <span>No</span>
                                                </div>
                                            </div>


                                            <div class="col-md-4">
                                                <div class="field">
                                                    <label for="">Referral requirement</label>
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="text">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="field">
                                                    <label for="">Referral agency</label>
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="text">
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="field">
                                                    <label for="">Date referral response</label>
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="date">
                                                </div>
                                            </div>
                                            <div class="col-12 mt-5">
                                                <p>Identify and describe any changes made to the proposed development application that was the subject of the referral response and this development application, or include details in a schedule to this development application (if applicable)</p>
                                            </div>



                                        </div>

                                        <div class="row mt-5">

                                            <div class="row mb-4">
                                                <h3 class="mb-3">
                                                    14) Owner’s details
                                                </h3>
                                                <div class="checkbox_div">
                                                    <label class="check_div">
                                                        <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                        <div class="checkmark"></div>
                                                    </label>
                                                    <span>Tick if the applicant is also the owner and proceed to 15). Otherwise, provide the following information.</span>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="field">
                                                        <label for="">Name(s) (individual or company full name)</label>
                                                        <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="text">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="field">
                                                        <label for="">Contact name (applicable for companies)</label>
                                                        <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="text">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="field">
                                                        <label for="">Postal address (P.O. Box or street address)</label>
                                                        <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="text">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="field">
                                                        <label for="">Suburb</label>
                                                        <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="text">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="field">
                                                        <label for="">State</label>
                                                        <div class="form-floating">
                                                            <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                                                                <option selected>Select State</option>
                                                                <option value="1">One</option>
                                                                <option value="2">Two</option>
                                                                <option value="3">Three</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="field">
                                                        <label for="">Postcode</label>
                                                        <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="text">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="field">
                                                        <label for="">Country</label>
                                                        <div class="form-floating">
                                                            <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                                                                <option selected>Select Country</option>
                                                                <option value="1">One</option>
                                                                <option value="2">Two</option>
                                                                <option value="3">Three</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="field">
                                                        <label for="">Contact number</label>
                                                        <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="text">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="field">
                                                        <label for="">Email address (non-mandatory)</label>
                                                        <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="email">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="field">
                                                        <label for="">Mobile number (non-mandatory)</label>
                                                        <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="number">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="field">
                                                        <label for="">Fax number (non-mandatory)</label>
                                                        <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="number">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row mb-3 mt-5">
                                                <h3 class="mb-0">15) Builder’s details</h3>
                                                <div class="checkbox_div mt-4">
                                                    <label class="check_div">
                                                        <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                        <div class="checkmark"></div>
                                                    </label>
                                                    <span>Tick if a builder has not yet been engaged to undertake the work and proceed to 16). Otherwise provide the following information.</span>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="field">
                                                        <label for="">Name(s) (individual or company full name)</label>
                                                        <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="text">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="field">
                                                        <label for="">Contact name (applicable for companies)</label>
                                                        <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="number">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="field">
                                                        <label for="">QBCC licence or owner – builder number</label>
                                                        <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="number">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="field">
                                                        <label for="">Postal address (P.O. Box or street address)</label>
                                                        <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="text">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="field">
                                                        <label for="">Suburb</label>
                                                        <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="text">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="field">
                                                        <label for="">State</label>
                                                        <div class="form-floating">
                                                            <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                                                                <option selected>Select State</option>
                                                                <option value="1">One</option>
                                                                <option value="2">Two</option>
                                                                <option value="3">Three</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="field">
                                                        <label for="">Postcode</label>
                                                        <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="text">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="field">
                                                        <label for="">Country</label>
                                                        <div class="form-floating">
                                                            <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                                                                <option selected>Select Country</option>
                                                                <option value="1">One</option>
                                                                <option value="2">Two</option>
                                                                <option value="3">Three</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="field">
                                                        <label for="">Contact number</label>
                                                        <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="text">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="field">
                                                        <label for="">Email address (non-mandatory)</label>
                                                        <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="email">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="field">
                                                        <label for="">Mobile number (non-mandatory)</label>
                                                        <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="number">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="field">
                                                        <label for="">Fax number (non-mandatory)</label>
                                                        <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="number">
                                                    </div>
                                                </div>
                                            </div>




                                            <div class="row mb-3 mt-5">
                                                <h3 class="mb-3">16) Provide details about the proposed building work </h3>
                                                <div class="mb-3">
                                                    <h5 class="mb-3">a) What type of approval is being sought?</h5>
                                                        <div class="checkbox_div">
                                                            <label class="check_div">
                                                                <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                                <div class="checkmark"></div>
                                                            </label>
                                                            <span> Development permit</span>
                                                        </div>
                                                        <div class="checkbox_div">
                                                            <label class="check_div">
                                                                <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                                <div class="checkmark"></div>
                                                            </label>
                                                            <span> Preliminary approval</span>
                                                        </div>
                                                </div>

                                                <div class="mb-3">
                                                    <h5 class="mb-3">b) What is the level of assessment?</h5>
                                                        <div class="checkbox_div">
                                                            <label class="check_div">
                                                                <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                                <div class="checkmark"></div>
                                                            </label>
                                                            <span>Code assessment</span>
                                                        </div>
                                                        <div class="checkbox_div">
                                                            <label class="check_div">
                                                                <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                                <div class="checkmark"></div>
                                                            </label>
                                                            <span> Impact assessment (requires public notification)</span>
                                                        </div>
                                                </div>

                                                <div class="mb-3">
                                                    <h5 class="mb-3">c) Nature of the proposed building work (tick all applicable boxes)</h5>
                                                        <div class="row">
                                                            <div class="checkbox_div col-md-6">
                                                                <label class="check_div">
                                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                                    <div class="checkmark"></div>
                                                                </label>
                                                                <span>New building or structure</span>
                                                            </div>
                                                            <div class="checkbox_div col-md-6">
                                                                <label class="check_div">
                                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                                    <div class="checkmark"></div>
                                                                </label>
                                                                <span>Repairs, alterations or additions</span>
                                                            </div>
                                                            <div class="checkbox_div col-md-6">
                                                                <label class="check_div">
                                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                                    <div class="checkmark"></div>
                                                                </label>
                                                                <span>Change of building classification (involving building work)</span>
                                                            </div>
                                                            <div class="checkbox_div col-md-6">
                                                                <label class="check_div">
                                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                                    <div class="checkmark"></div>
                                                                </label>
                                                                <span>Swimming pool and/or pool fence</span>
                                                            </div>
                                                            <div class="checkbox_div col-md-6">
                                                                <label class="check_div">
                                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                                    <div class="checkmark"></div>
                                                                </label>
                                                                <span>Demolition</span>
                                                            </div>
                                                            <div class="checkbox_div col-md-6">
                                                                <label class="check_div">
                                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                                    <div class="checkmark"></div>
                                                                </label>
                                                                <span>Relocation or removal</span>
                                                            </div>
                                                        </div>
                                                </div>

                                                <div class="mb-3">
                                                    <h5 class="mb-3">d) Provide a description of the work below or in an attached schedule.</h5>
                                                    <div class="field">
                                                        <textarea name="" id=""></textarea>
                                                    </div>
                                                </div>




                                                <div class="mb-3">
                                                    <h5 class="mb-3">e) Proposed construction materials</h5>

                                                    <div class="section">
                                                        <h6 class="mb-3 mt-3">External walls</h6>
                                                        <div class="row">
                                                            <div class="checkbox_div col-md-3">
                                                                <label class="check_div">
                                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                                    <div class="checkmark"></div>
                                                                </label>
                                                                <span>Double brick</span>
                                                            </div>
                                                            <div class="checkbox_div col-md-3">
                                                                <label class="check_div">
                                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox" checked>
                                                                    <div class="checkmark"></div>
                                                                </label>
                                                                <span>Brick veneer</span>
                                                            </div>
                                                            <div class="checkbox_div col-md-3">
                                                                <label class="check_div">
                                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                                    <div class="checkmark"></div>
                                                                </label>
                                                                <span>Stone/concrete</span>
                                                            </div>
                                                            <div class="checkbox_div col-md-3">
                                                                <label class="check_div">
                                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox" checked>
                                                                    <div class="checkmark"></div>
                                                                </label>
                                                                <span>Steel</span>
                                                            </div>
                                                            <div class="checkbox_div col-md-3">
                                                                <label class="check_div">
                                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                                    <div class="checkmark"></div>
                                                                </label>
                                                                <span>Timber</span>
                                                            </div>
                                                            <div class="checkbox_div col-md-3">
                                                                <label class="check_div">
                                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                                    <div class="checkmark"></div>
                                                                </label>
                                                                <span>Fibre cement</span>
                                                            </div>
                                                            <div class="checkbox_div col-md-3">
                                                                <label class="check_div">
                                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                                    <div class="checkmark"></div>
                                                                </label>
                                                                <span>Curtain glass</span>
                                                            </div>
                                                            <div class="checkbox_div col-md-3">
                                                                <label class="check_div">
                                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                                    <div class="checkmark"></div>
                                                                </label>
                                                                <span>Aluminium</span>
                                                            </div>
                                                            <div class="checkbox_div col-md-3">
                                                                <label class="check_div">
                                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                                    <div class="checkmark"></div>
                                                                </label>
                                                                <span>Other</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="section">
                                                        <h6 class="mb-3 mt-4">Frame</h6>
                                                            <div class="row">
                                                                <div class="checkbox_div col-md-3">
                                                                    <label class="check_div">
                                                                        <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                                        <div class="checkmark"></div>
                                                                    </label>
                                                                    <span>Timber</span>
                                                                </div>
                                                                <div class="checkbox_div col-md-3">
                                                                    <label class="check_div">
                                                                        <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox" checked>
                                                                        <div class="checkmark"></div>
                                                                    </label>
                                                                    <span>Steel</span>
                                                                </div>
                                                                <div class="checkbox_div col-md-3">
                                                                    <label class="check_div">
                                                                        <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                                        <div class="checkmark"></div>
                                                                    </label>
                                                                    <span>Aluminium</span>
                                                                </div>
                                                                <div class="checkbox_div col-md-3">
                                                                    <label class="check_div">
                                                                        <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                                        <div class="checkmark"></div>
                                                                    </label>
                                                                    <span>Other</span>
                                                                </div>
                                                            </div>
                                                    </div>

                                                    <div class="section">
                                                        <h6 class="mb-3 mt-4">Floor</h6>
                                                        <div class="row">
                                                            <div class="checkbox_div col-md-3">
                                                                <label class="check_div">
                                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox" checked>
                                                                    <div class="checkmark"></div>
                                                                </label>
                                                                <span>Concrete</span>
                                                            </div>
                                                            <div class="checkbox_div col-md-3">
                                                                <label class="check_div">
                                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                                    <div class="checkmark"></div>
                                                                </label>
                                                                <span>Timber</span>
                                                            </div>
                                                            <div class="checkbox_div col-md-3">
                                                                <label class="check_div">
                                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                                    <div class="checkmark"></div>
                                                                </label>
                                                                <span>Other</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="section">
                                                        <h6 class="mb-3 mt-4">Roof covering</h6>
                                                        <div class="row">
                                                            <div class="checkbox_div col-md-3">
                                                                <label class="check_div">
                                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                                    <div class="checkmark"></div>
                                                                </label>
                                                                <span>Slate/concrete</span>
                                                            </div>
                                                            <div class="checkbox_div col-md-3">
                                                                <label class="check_div">
                                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                                    <div class="checkmark"></div>
                                                                </label>
                                                                <span>Tiles</span>
                                                            </div>
                                                            <div class="checkbox_div col-md-3">
                                                                <label class="check_div">
                                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                                    <div class="checkmark"></div>
                                                                </label>
                                                                <span>Fibre cement</span>
                                                            </div>
                                                            <div class="checkbox_div col-md-3">
                                                                <label class="check_div">
                                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox" checked>
                                                                    <div class="checkmark"></div>
                                                                </label>
                                                                <span>Steel</span>
                                                            </div>
                                                            <div class="checkbox_div col-md-3">
                                                                <label class="check_div">
                                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                                    <div class="checkmark"></div>
                                                                </label>
                                                                <span>Aluminium</span>
                                                            </div>
                                                            <div class="checkbox_div col-md-3">
                                                                <label class="check_div">
                                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                                    <div class="checkmark"></div>
                                                                </label>
                                                                <span>Other</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <h5 class="mb-2 mt-4">f) Existing building use/classification? (if applicable)</h5>
                                                        <div class="row ">
                                                            <div class="checkbox_div col-md-4">
                                                                <label class="check_div">
                                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                                    <div class="checkmark"></div>
                                                                </label>
                                                                <span>Yes – provide details below</span>
                                                            </div>
                                                            <div class="checkbox_div col-md-4">
                                                                <label class="check_div">
                                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                                    <div class="checkmark"></div>
                                                                </label>
                                                                <span>No</span>
                                                            </div>
                                                        </div>

                                                        <h5 class="mb-2 mt-4">g) New building use/classification? (if applicable)</h5>
                                                        <div class="row ">
                                                            <div class="checkbox_div col-md-4">
                                                                <label class="check_div">
                                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                                    <div class="checkmark"></div>
                                                                </label>
                                                                <span>Yes – provide details below</span>
                                                            </div>
                                                            <div class="checkbox_div col-md-4">
                                                                <label class="check_div">
                                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                                    <div class="checkmark"></div>
                                                                </label>
                                                                <span>No</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <h5 class="mb-2">h) Relevant plans</h5>
                                                        <p>Note: Relevant plans are required to be submitted for all aspects of this development application. For further information, see DA Forms Guide: Relevant plans.</p>

                                                        <div class="row mt-4">
                                                            <div class="checkbox_div col-md-12">
                                                                <label class="check_div">
                                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                                    <div class="checkmark"></div>
                                                                </label>
                                                                <span>Relevant plans of the proposed works are attached to the development application</span>
                                                            </div>
                                                        </div>

                                                        <div class="checkbox_div col-md-4">
                                                            <label class="check_div">
                                                                <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                                <div class="checkmark"></div>
                                                            </label>
                                                            <span>Yes – provide details below</span>
                                                        </div>

                                                        <div class="checkbox_div col-md-4">
                                                            <label class="check_div">
                                                                <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                                <div class="checkmark"></div>
                                                            </label>
                                                            <span>No</span>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="field">
                                                                <label for="">Amount paid</label>
                                                                <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="text">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="field">
                                                                <label for="">Date paid (dd/mm/yy)</label>
                                                                <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="text">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <div class="field">
                                                                <label for="">Reference number</label>
                                                                <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="date">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>


                                        </div>

                                        <div class="mb-3 row">
                                            <h3 class="mb-3">19) Development application checklist</h3>
                                            <h5 class="mb-2 mt-3">The relevant parts of Form 2 – Building work details have been completed</h5>
                                                <div class="checkbox_div">
                                                    <label class="check_div">
                                                        <input checked="checked" placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                        <div class="checkmark"></div>
                                                    </label>
                                                    <span>yes</span>
                                                </div>

                                                <h5 class="mb-2 mt-3">This development application includes a material change of use, reconfiguring a lot or operational work and is accompanied by a completed Form 1 – Development application details</h5>
                                                    <div class="checkbox_div">
                                                        <label class="check_div">
                                                            <input checked="checked" placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                            <div class="checkmark"></div>
                                                        </label>
                                                        <span>yes</span>
                                                    </div>
                                                    <div class="checkbox_div">
                                                        <label class="check_div">
                                                            <input checked="checked" placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                            <div class="checkmark"></div>
                                                        </label>
                                                        <span>Not applicable</span>
                                                    </div>

                                                    <h5 class="mb-2 mt-3">Relevant plans of the development are attached to this development application
                                                        Note: Relevant plans are required to be submitted for all aspects of this development application. For further information, see DA Forms Guide: Relevant plans.</h4>
                                                        <div class="checkbox_div">
                                                            <label class="check_div">
                                                                <input checked="checked" placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                                <div class="checkmark"></div>
                                                            </label>
                                                            <span>yes</span>
                                                        </div>


                                                        <h5 class="mb-2 mt-3">This development application includes a material change of use, reconfiguring a lot or operational work and is accompanied by a completed Form 1 – Development application details</h5>
                                                            <div class="checkbox_div">
                                                                <label class="check_div">
                                                                    <input checked="checked" placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                                    <div class="checkmark"></div>
                                                                </label>
                                                                <span>yes</span>
                                                            </div>
                                                            <div class="checkbox_div">
                                                                <label class="check_div">
                                                                    <input checked="checked" placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                                    <div class="checkmark"></div>
                                                                </label>
                                                                <span>Not applicable</span>
                                                            </div>
                                        </div>


                                        <div class="row mt-5">
                                            <h3 class="mb-3">20) Applicant declaration</h3>
                                            <div class="checkbox_div">
                                                <label class="check_div">
                                                    <input checked="checked" placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                    <div class="checkmark"></div>
                                                </label>
                                                <span>By making this development application, I declare that all information in this development application is true and correct</span>
                                            </div>
                                            <div class="checkbox_div">
                                                <label class="check_div">
                                                    <input checked="checked" placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                    <div class="checkmark"></div>
                                                </label>
                                                <span> Where an email address is provided in Part 1 of this form, I consent to receive future electronic communications from the assessment manager and any referral agency for the development application where written information is required or permitted pursuant to sections 11 and 12 of the Electronic Transactions Act 2001</span>
                                            </div>

                                            <p class="mt-3">
                                                <strong>Privacy</strong> – Personal information collected in this form will be used by the assessment manager and/or chosen assessment manager, any referral agency and/or building certifier (including any professional advisers which may be engaged by those entities) while processing, assessing and deciding the development application.
                                            </p>
                                            <p class="mb-3">All information relating to this development application may be available for inspection and purchase, and/or published on the assessment manager’s and/or referral agency’s website.</p>
                                            <p class="mb-3">Personal information will not be disclosed for a purpose unrelated to the Planning Act 2016, Planning Regulation 2017 and the DA Rules except where:</p>

                                            <ul>
                                                <li class="mb-2">such disclosure is in accordance with the provisions about public access to documents contained in the Planning Act 2016 and the Planning Regulation 2017, and the access rules made under the Planning Act 2016 and Planning Regulation 2017; or</li>
                                                <li class="mb-2">required by other legislation (including the Right to Information Act 2009); or</li>
                                                <li class="mb-2">otherwise required by law. </li>
                                            </ul>

                                            <p class="mb-3">This information may be stored in relevant databases. The information collected will be retained as required by the Public Records Act 2002.</p>

                                        </div>

                                        <div class="row mt-5" >


                                            <div class="col-md-6">
                                                <div class="field">
                                                    <label for="">Date received:</label>
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="date">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="field">
                                                    <label for="">Reference numbers:</label>
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="number">
                                                </div>
                                            </div>
                                            <h4 class="mt-4 mb-0">Classification(s) of approved building work</h4>
                                            <div class="col-md-6">
                                                <div class="field">
                                                    <label for="">Name</label>
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="text">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="field">
                                                    <label for="">QBCC Certification Licence number</label>
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="text">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="field">
                                                    <label for="">QBCC Insurance receipt number</label>
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="number">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="field">
                                                    <label for="">Prescribed assessment manager</label>
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="text">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="field">
                                                    <label for="">Name of chosen assessment manager</label>
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="text">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="field">
                                                    <label for="">number chosen assessment manager engaged</label>
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="number">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="field">
                                                    <label for="">Contact number of chosen assessment manager</label>
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="number">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="field">
                                                    <label for="">Relevant licence number(s) of chosen assessment manager</label>
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="number">
                                                </div>
                                            </div>

                                            <h3 class="mb-3 mt-5">Additional information required by the local government</h3>
                                            <h4 class="mt-4 mb-2"> Confirm proposed construction materials: </h4>
                                            <div class="section">
                                                <h5 class="mb-3 mt-3">External walls</h5>
                                                <div class="row">
                                                    <div class="checkbox_div col-md-3">
                                                        <label class="check_div">
                                                            <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                            <div class="checkmark"></div>
                                                        </label>
                                                        <span>Double brick</span>
                                                    </div>
                                                    <div class="checkbox_div col-md-3">
                                                        <label class="check_div">
                                                            <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox" checked>
                                                            <div class="checkmark"></div>
                                                        </label>
                                                        <span>Brick veneer</span>
                                                    </div>
                                                    <div class="checkbox_div col-md-3">
                                                        <label class="check_div">
                                                            <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                            <div class="checkmark"></div>
                                                        </label>
                                                        <span>Stone/concrete</span>
                                                    </div>
                                                    <div class="checkbox_div col-md-3">
                                                        <label class="check_div">
                                                            <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox" checked>
                                                            <div class="checkmark"></div>
                                                        </label>
                                                        <span>Steel</span>
                                                    </div>
                                                    <div class="checkbox_div col-md-3">
                                                        <label class="check_div">
                                                            <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                            <div class="checkmark"></div>
                                                        </label>
                                                        <span>Timber</span>
                                                    </div>
                                                    <div class="checkbox_div col-md-3">
                                                        <label class="check_div">
                                                            <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                            <div class="checkmark"></div>
                                                        </label>
                                                        <span>Fibre cement</span>
                                                    </div>
                                                    <div class="checkbox_div col-md-3">
                                                        <label class="check_div">
                                                            <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                            <div class="checkmark"></div>
                                                        </label>
                                                        <span>Curtain glass</span>
                                                    </div>
                                                    <div class="checkbox_div col-md-3">
                                                        <label class="check_div">
                                                            <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                            <div class="checkmark"></div>
                                                        </label>
                                                        <span>Aluminium</span>
                                                    </div>
                                                    <div class="checkbox_div col-md-3">
                                                        <label class="check_div">
                                                            <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                            <div class="checkmark"></div>
                                                        </label>
                                                        <span>Other</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="section">
                                                <h5 class="mb-3 mt-4">Frame</h5>
                                                <div class="row">
                                                    <div class="checkbox_div col-md-3">
                                                        <label class="check_div">
                                                            <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                            <div class="checkmark"></div>
                                                        </label>
                                                        <span>Timber</span>
                                                    </div>
                                                    <div class="checkbox_div col-md-3">
                                                        <label class="check_div">
                                                            <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox" checked>
                                                            <div class="checkmark"></div>
                                                        </label>
                                                        <span>Steel</span>
                                                    </div>
                                                    <div class="checkbox_div col-md-3">
                                                        <label class="check_div">
                                                            <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                            <div class="checkmark"></div>
                                                        </label>
                                                        <span>Aluminium</span>
                                                    </div>
                                                    <div class="checkbox_div col-md-3">
                                                        <label class="check_div">
                                                            <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                            <div class="checkmark"></div>
                                                        </label>
                                                        <span>Other</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="section">
                                                <h5 class="mb-3 mt-4">Floor</h5>
                                                <div class="row">
                                                    <div class="checkbox_div col-md-3">
                                                        <label class="check_div">
                                                            <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox" checked>
                                                            <div class="checkmark"></div>
                                                        </label>
                                                        <span>Concrete</span>
                                                    </div>
                                                    <div class="checkbox_div col-md-3">
                                                        <label class="check_div">
                                                            <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                            <div class="checkmark"></div>
                                                        </label>
                                                        <span>Timber</span>
                                                    </div>
                                                    <div class="checkbox_div col-md-3">
                                                        <label class="check_div">
                                                            <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                            <div class="checkmark"></div>
                                                        </label>
                                                        <span>Other</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="section">
                                                <h5 class="mb-3 mt-4">Roof covering</h5>
                                                <div class="row">
                                                    <div class="checkbox_div col-md-3">
                                                        <label class="check_div">
                                                            <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                            <div class="checkmark"></div>
                                                        </label>
                                                        <span>Slate/concrete</span>
                                                    </div>
                                                    <div class="checkbox_div col-md-3">
                                                        <label class="check_div">
                                                            <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                            <div class="checkmark"></div>
                                                        </label>
                                                        <span>Tiles</span>
                                                    </div>
                                                    <div class="checkbox_div col-md-3">
                                                        <label class="check_div">
                                                            <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                            <div class="checkmark"></div>
                                                        </label>
                                                        <span>Fibre cement</span>
                                                    </div>
                                                    <div class="checkbox_div col-md-3">
                                                        <label class="check_div">
                                                            <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox" checked>
                                                            <div class="checkmark"></div>
                                                        </label>
                                                        <span>Steel</span>
                                                    </div>
                                                    <div class="checkbox_div col-md-3">
                                                        <label class="check_div">
                                                            <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                            <div class="checkmark"></div>
                                                        </label>
                                                        <span>Aluminium</span>
                                                    </div>
                                                    <div class="checkbox_div col-md-3">
                                                        <label class="check_div">
                                                            <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="checkbox">
                                                            <div class="checkmark"></div>
                                                        </label>
                                                        <span>Other</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="field">
                                                    <label for="">Description of the work</label>
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="text">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="field">
                                                    <label for="">QLeave project number</label>
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="number">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="field">
                                                    <label for="">Amount paid ($)</label>
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="number">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="field">
                                                    <label for="">Date paid (dd/mm/yy)</label>
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="date">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="field">
                                                    <label for="">Date receipted form sighted by assessment manager</label>
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="date">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="field">
                                                    <label for="">Name of officer who sighted the form</label>
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="text">
                                                </div>
                                            </div>

                                            <h4 class="mt-5">Additional building details required for the Australian Bureau of Statistics </h4>
                                            <div class="col-md-6">
                                                <div class="field">
                                                    <label for="">Existing building use/classification? (if applicable)</label>
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="text">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="field">
                                                    <label for="">New building use/classification?</label>
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="text">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="field">
                                                    <label for="">Site area (m2)</label>
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="text">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="field">
                                                    <label for="">Floor area (m2)</label>
                                                    <input placeholder="Lorem Ipsum is simply dummy text of the printing "  type ="text">
                                                </div>
                                            </div>


                                        </div>

                                    </div>

                                </div>
                            </div>

                        </section>

                    </div>
                </div>
            </div>

        </div>

    </div>
</div>



<?php include './includes/faq.php'; ?>

<?php include './includes/footer.php'; ?>