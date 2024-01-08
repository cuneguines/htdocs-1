<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="description" content="meta description">
    <meta name="viewpport" content="width=device-width, initial-scale = 1">
    <title>Kent Stainless</title>
    <link rel="stylesheet" href="../../../css/KS_DASH_STYLE.css">
    <script type="text/javascript" src="../../../JS/LIBS/jquery-3.4.1.js"></script>
    <script type="text/javascript" src="../../../JS/LIBS/canvasjs.min.js"></script>
    <script type="text/javascript" src="../../../JS/LOCAL/JS_menu_select.js"></script>
    <script type="text/javascript" src="./JS_togglecharttable.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../../CSS/KS_DASH_STYLE.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <link rel="stylesheet" type="text/css" href="{{ asset('/css/app.css')}}">
</head>
<style>
button {
    width: 20%;
    padding: 10px;
    background-color: #FACB57;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    border-radius: 20px;
    margin-left: 33%;
    margin-top: 1%;
    margin-bottom: 0.5%;
}

fieldset {

    font-size: 10px;
    width: 40%;
    /* Adjust the width as needed */
    display: inline-block;
    margin-left: 1%;
    vertical-align: top;
    height: 300px;
    background-color: white;
}

textarea {
    width: 90%;
    /* Adjust the width as needed */
}
</style>

<body>
    <div id="background" style="background-color:#E8E8E8">
        <div id="navmenu" style="height:106%">
            <div>
                <p id="title" id="title" onclick="location.href='../MAIN/MAIN_MENU.php'">Kent Stainless</p>
            </div>
            <nav>
                <ul id="dashboard_list">
                    <li id="management_option" class="dashboard_option inactivebtn"
                        onclick="location.href='../MANAGEMENT SUBMENU/BASE_management_menu.php'">Operator</li>
                    <li id="sales_option" class="dashboard_option inactivebtn"
                        onclick="location.href='http://127.0.0.1:8000/kitting_task'">Kitting</li>
                    <li id="engineering_option" class="dashboard_option activebtn"
                        onclick="location.href='../ENGINEERING SUBMENU/BASE_engineering_menu.php'">Engineer</li>
                    <li id="production_option" class="dashboard_option inactivebtn"
                        onclick="location.href='../PRODUCTION SUBMENU/BASE_production_menu.php'">RWC</li>
                    <li id="intel_option" class="dashboard_option inactivebtn"
                        onclick="location.href='../INTEL SUBMENU/BASE_intel_workflow.php'">QA</li>

                    <br>
                    <li id="livetracker_option" class="dashboard_option inactivebtn"
                        onclick="location.href='../../../../VISUAL Management SYSTEM/LIVE/Livetracker_1_3_0'">
                        LIVETRACKER</li>
                </ul>
            </nav>
            <div id="lastupdateholder">
            </div>
        </div>
        <form action="process_form.php" method="post" enctype="multipart/form-data">
            <!-- Main Task 1: Planning / Forward Engineering -->
            <fieldset>
                <legend>Main Task 1: Planning / Forward Engineering</legend>

                <!-- Subtask 1.1: Purchase Order -->
                <label>
                    <input type="checkbox" name="purchase_order_received">
                    Purchase Order received
                </label>
                <br>

                <!-- Subtask 1.2: Project Schedule -->
                <label>
                    <input type="checkbox" name="project_schedule_agreed">
                    Project schedule agreed
                </label>
                <br>

                <!-- Subtask 1.3: Quotation -->
                <label>
                    <input type="checkbox" name="quotation">
                    Quotation
                </label>
                <br>

                <!-- Subtask 1.4: User Requirement Specifications -->
                <label>
                    <input type="checkbox" name="verify_customer_expectations">
                    Verify customer expectations
                </label>
                <br>

                <!-- Subtask 1.5: Pre Engineering Check -->
                <label>
                    <input type="checkbox" name="project_risk_category_assessment">
                    Project risk category assessment
                </label>
                <br>

                <!-- Upload Document for Subtask 1.1 -->
                <label>
                    Upload Purchase Order Document:
                    <input type="file" name="purchase_order_document">
                </label>
                <br>

                <!-- Upload Document for Subtask 1.3 -->
                <label>
                    Upload Quotation Document:
                    <input type="file" name="quotation_document">
                </label>
                <br>

                <!-- Sign-off for Main Task 1 -->
                <label>
                    Sign-off for Planning / Forward Engineering:
                    <input type="text" name="sign_off_planning">
                </label>
                <br>

                <!-- Comments for Main Task 1 -->
                <label>
                    Comments for Planning / Forward Engineering:
                    <textarea name="comments_planning" rows="4" cols="50"></textarea>
                </label>
                <br>
            </fieldset>

            <!-- Main Task 2: Engineering -->
            <fieldset>
                <legend>Main Task 2: Engineering</legend>

                <!-- Subtask 2.1: Reference Job / Master File -->
                <label>
                    <input type="checkbox" name="reference_job_master_file">
                    Reference Job / Master File if applicable
                </label>
                <br>

                <!-- Subtask 2.2: Concept Design -->
                <label>
                    <input type="checkbox" name="concept_design_engineering_details">
                    Concept design & engineering details
                </label>
                <br>

                <!-- Subtask 2.3: Design Validation -->
                <label>
                    <input type="checkbox" name="design_validation_sign_off">
                    Design sign off [calculations]
                </label>
                <br>

                <!-- Subtask 2.4: Customer Approval -->
                <label>
                    <input type="checkbox" name="customer_submittal_package">
                    Customer submittal package
                </label>
                <br>

                <!-- Subtask 2.5: Sample Approval -->
                <label>
                    <input type="checkbox" name="reference_approved_samples">
                    Reference approved samples
                </label>
                <br>

                <!-- Upload Document for Subtask 2.2 -->
                <label>
                    Upload Concept Design Document:
                    <input type="file" name="concept_design_document">
                </label>
                <br>

                <!-- Upload Document for Subtask 2.4 -->
                <label>
                    Upload Customer Approval Document:
                    <input type="file" name="customer_approval_document">
                </label>
                <br>

                <!-- Sign-off for Main Task 2 -->
                <label>
                    Sign-off for Engineering:
                    <input type="text" name="sign_off_engineering">
                </label>
                <br>

                <!-- Comments for Main Task 2 -->
                <label>
                    Comments for Engineering:
                    <textarea name="comments_engineering" rows="4" cols="50"></textarea>
                </label>
                <br>
            </fieldset>

            <fieldset>
                <legend>Manufacturing Package</legend>

                <!-- Subtask 3.1 -->
                <label>
                    <input type="checkbox" name="production_drawings">
                    3.1 Production Drawings - Complete production drawing package
                </label>
                <br>

                <!-- Subtask 3.2 -->
                <label>
                    <input type="checkbox" name="bom">
                    3.2 BOM - BOM + Subcontract and bough outs
                </label>
                <br>

                <!-- Subtask 3.3 -->
                <label>
                    <input type="checkbox" name="machine_programming">
                    3.3 Laser, CNC machining, saw - Transfer files for machine programming
                </label>
                <br>

                <!-- Subtask 3.4 -->
                <label>
                    <input type="checkbox" name="ndt_documentation">
                    3.4 NDT Documentation - Project specific ITP & Inspection Documents
                </label>
                <br>

                <!-- Subtask 3.5 -->
                <label>
                    <input type="checkbox" name="quality_documents">
                    3.5 Quality Documents - Printed and in QA Envelope
                </label>
                <br>

            </fieldset>
            <fieldset>
                <legend>Material Preparation</legend>

                <!-- Subtask 4.1 -->
                <label>
                    <input type="checkbox" name="material_identification">
                    4.1 Material Identification - Confirm grade, thickness - Operator (Pulled from SAP)
                </label>
                <br>

                <!-- Subtask 4.2 -->
                <label>
                    <input type="checkbox" name="material_identification_record">
                    4.2 Material Identification Record - 3.1 Mill Test Certificate [EN 1024] - Engineer (Link to
                    Material Cert)
                </label>
                <br>

                <!-- Subtask 4.3 -->
                <label>
                    <input type="checkbox" name="material_traceability">
                    4.3 Material Traceability - Heat Number - Engineer (Pulled from SAP)
                </label>
                <br>

                <!-- Subtask 4.4 -->
                <label>
                    <input type="checkbox" name="cutting">
                    4.4 Cutting - Part geometry, cut quality, part qty - Operator
                </label>
                <br>

                <!-- Subtask 4.5 -->
                <label>
                    <input type="checkbox" name="deburring">
                    4.5 De-burring - No sharp edges - Operator
                </label>
                <br>

                <!-- Subtask 4.6 -->
                <label>
                    <input type="checkbox" name="forming">
                    4.6 Forming - Part geometry, part qty - Operator
                </label>
                <br>

                <!-- Subtask 4.7 -->
                <label>
                    <input type="checkbox" name="machining">
                    4.7 Machining - Part geometry, part qty - Operator
                </label>
                <br>

            </fieldset>
            <fieldset>
                <legend>Welding</legend>

                <!-- Subtask 7.1 -->
                <label>
                    <input type="checkbox" name="weld_map">
                    7.1 Weld Map - Weld Map issued to production - Engineer (Link to Weld Map)
                </label>
                <br>

                <!-- Subtask 7.2 -->
                <label>
                    <input type="checkbox" name="weld_procedure_qualification_record">
                    7.2 Weld Procedure Qualification Record - EN ISO 15614 - Engineer (Link to PQR)
                </label>
                <br>

                <!-- Subtask 7.3 -->
                <label>
                    <input type="checkbox" name="weld_procedure_specifications">
                    7.3 Weld Procedure Specifications - EN ISO 15615 - Engineer (Link to Approved WPS)
                </label>
                <br>

                <!-- Add more subtasks as needed -->

            </fieldset>
            <fieldset>
                <legend>Testing</legend>

                <!-- Subtask 8.1 -->
                <label>
                    <input type="checkbox" name="dye_penetrant_procedure">
                    Select Dye Penetrant Procedure - Dye Pen Document REF No (Drop down list) - Operator (Link to SOP)
                </label>
                <br>

                <!-- Subtask 8.2 -->
                <label>
                    <input type="checkbox" name="hydrostatic_leak_test">
                    Hydrostatic Leak Test - Hydrostatic Testing as per specification Document REF No (Drop down list) -
                    Operator (Link to SOP)
                </label>
                <br>

                <!-- Subtask 8.3 -->
                <label>
                    <input type="checkbox" name="pneumatic_leak_test">
                    Pneumatic Leak Test - Pneumatic Testing as per specification Document REF No (Drop down list) -
                    Operator (Link to SOP)
                </label>
                <br>

                <!-- Subtask 8.4 -->
                <label>
                    <input type="checkbox" name="fat">
                    FAT - Refer to Project FAT Protocol - Engineer (Link to Doc)
                </label>
                <br>

                <!-- Add more subtasks as needed -->

            </fieldset>
            <div>
                <button type="submit">Submit</button>
            </div>
        </form>

        <!-- FINANCE MENU -->


    </div>
</body>

</html>