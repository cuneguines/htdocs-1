<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PDF;

class PDFController extends Controller



{


    public function fetchData(Request $request)
    {
        // Validate the request input
        $request->validate([
            'processOrderNumber' => 'required|string'
        ]);

        // Get the process order number from the request
        $processOrderNumber = $request->input('processOrderNumber');

        // Fetch data from the database using the process order number
        $data1 = DB::table('MaterialPreparationFormData')
            ->where('process_order_number', $processOrderNumber)
            ->limit(1000)
            ->get();

        $data2 = DB::table('MaterialPreparationFormCompleteData')
            ->where('process_order_number', $processOrderNumber)
            ->limit(1000)
            ->get();
         

        // Render the fetched data in a view and return it as HTML for the modal
        return view('data.modal-content', compact('data1', 'data2', 'processOrderNumber'))->render();
    }

    public function generatePDF(Request $request)
    {
        // Validate the request input
        $request->validate([
            'processOrderNumber' => 'required|string'
        ]);

        // Get the process order number from the request
        $processOrderNumber = $request->input('processOrderNumber');
//$processOrderNumber=50000;
        // Fetch data from the database using the process order number
        $data1 = DB::table('QUALITY_PACK.dbo.MaterialPreparationFormData as mpf')
            ->join('QUALITY_PACK.dbo.User as u', 'mpf.sign_off_material_preparation', '=', 'u.Login')
            ->where('mpf.process_order_number', $processOrderNumber)
            ->orderBy('mpf.updated_at', 'desc')
            ->limit(1)
            ->select([ 'process_order_number',
                'mpf.*',
                DB::raw("CONCAT(u.FirstName, ' ', u.LastName) as sign_off_material_preparation")
            ])
            ->get();

            /*$data_1 =  /* DB::table('QUALITY_PACK.dbo.MaterialPreparationFormCompleteData AS mpf')
            ->join('QUALITY_PACK.dbo.User AS u', 'u.Login', '=', 'mpf.sign_off_material_complete_preparation')
            ->where('mpf.process_order_number', '=', $processOrderNumber)
            ->orderBy('mpf.updated_at', 'desc')
            ->limit(1)
            ->select([
                'mpf.*',
                DB::raw("CONCAT(u.FirstName, ' ', u.LastName) AS sign_off_material_preparation",MAX(CASE WHEN mpf.forming IS NOT NULL THEN CONCAT(U.FirstName, ' ', U.LastName) END) AS forming,
                MAX(CASE WHEN mpf.deburring IS NOT NULL THEN CONCAT(U.FirstName, ' ', U.LastName) END) AS deburring,
                MAX(CASE WHEN mpf.machining IS NOT NULL THEN CONCAT(U.FirstName, ' ', U.LastName) END) AS machining,
                MAX(CASE WHEN mpf.cutting IS NOT NULL THEN CONCAT(U.FirstName, ' ', U.LastName) END) AS cutting)
            ]) ->get(); */

            $data_1 = DB::table('QUALITY_PACK.dbo.MaterialPreparationFormCompleteData AS mpf')
    ->join('QUALITY_PACK.dbo.User AS u', 'u.Login', '=', 'mpf.sign_off_material_complete_preparation')
    ->leftJoin(DB::raw('
        (SELECT 
            process_order_number,
            MAX(CASE WHEN deburring IS NOT NULL THEN 1 ELSE NULL END) AS deburring,
            MAX(deburring) AS max_deburring_value,
            MAX(CASE WHEN machining IS NOT NULL THEN 1 ELSE NULL END) AS machining,
            MAX(machining) AS max_machining_value,
            MAX(CASE WHEN cutting IS NOT NULL THEN 1 ELSE NULL END) AS cutting,
            MAX(cutting) AS max_cutting_value,
            MAX(CASE WHEN forming IS NOT NULL THEN 1 ELSE NULL END) AS forming,
            MAX(forming) AS max_forming_value
        FROM QUALITY_PACK.dbo.MaterialPreparationFormCompleteData
        GROUP BY process_order_number
        ) AS sub'), 'mpf.process_order_number', '=', 'sub.process_order_number')
    ->where('mpf.process_order_number', '=', $processOrderNumber)
    ->select([
        'mpf.*',
        'u.FirstName',
        'u.LastName',
        'sub.deburring',
        'sub.max_deburring_value',
        'sub.machining',
        'sub.max_machining_value',
        'sub.cutting',
        'sub.max_cutting_value',
        'sub.forming',
        'sub.max_forming_value',
    ])
    ->get();
 
        
        
            $data_11=   DB::select("
    WITH LatestChecks AS (
    SELECT 
        mpf.updated_at,
        'Forming' AS CheckType,
        CONCAT(U.FirstName, ' ', U.LastName) AS UserName,
        ROW_NUMBER() OVER (PARTITION BY mpf.process_order_number ORDER BY mpf.updated_at DESC) AS rn
    FROM 
        QUALITY_PACK.dbo.MaterialPreparationFormCompleteData AS mpf
    LEFT JOIN 
        QUALITY_PACK.dbo.[User] AS U ON U.Login = mpf.forming_person
    WHERE 
        mpf.forming = 'on' AND mpf.forming IS NOT NULL AND mpf.process_order_number = ?

    UNION ALL
	SELECT 
        mpf.updated_at,
        'Identification' AS CheckType,
        CONCAT(U.FirstName, ' ', U.LastName) AS UserName,
        ROW_NUMBER() OVER (PARTITION BY mpf.process_order_number ORDER BY mpf.updated_at DESC) AS rn
    FROM 
        QUALITY_PACK.dbo.MaterialPreparationFormCompleteData AS mpf
    LEFT JOIN 
        QUALITY_PACK.dbo.[User] AS U ON U.Login = mpf.deburring_person
    WHERE 
        mpf.material_identification = 'on' AND mpf.material_identification IS NOT NULL AND mpf.process_order_number = ?
UNION ALL
    SELECT 
        mpf.updated_at,
        'Deburring' AS CheckType,
        CONCAT(U.FirstName, ' ', U.LastName) AS UserName,
        ROW_NUMBER() OVER (PARTITION BY mpf.process_order_number ORDER BY mpf.updated_at DESC) AS rn
    FROM 
        QUALITY_PACK.dbo.MaterialPreparationFormCompleteData AS mpf
    LEFT JOIN 
        QUALITY_PACK.dbo.[User] AS U ON U.Login = mpf.deburring_person
    WHERE 
        mpf.deburring = 'on' AND mpf.deburring IS NOT NULL AND mpf.process_order_number = ?

    UNION ALL

    SELECT 
        mpf.updated_at,
        'Machining' AS CheckType,
        CONCAT(U.FirstName, ' ', U.LastName) AS UserName,
        ROW_NUMBER() OVER (PARTITION BY mpf.process_order_number ORDER BY mpf.updated_at DESC) AS rn
    FROM 
        QUALITY_PACK.dbo.MaterialPreparationFormCompleteData AS mpf
    LEFT JOIN 
        QUALITY_PACK.dbo.[User] AS U ON U.Login = mpf.machining_person
    WHERE 
        mpf.machining = 'on' AND mpf.machining IS NOT NULL AND mpf.process_order_number = ?

    UNION ALL

    SELECT 
        mpf.updated_at,
        'Cutting' AS CheckType,
        CONCAT(U.FirstName, ' ', U.LastName) AS UserName,
        ROW_NUMBER() OVER (PARTITION BY mpf.process_order_number ORDER BY mpf.updated_at DESC) AS rn
    FROM 
        QUALITY_PACK.dbo.MaterialPreparationFormCompleteData AS mpf
    LEFT JOIN 
        QUALITY_PACK.dbo.[User] AS U ON U.Login = mpf.cutting_person
    WHERE 
        mpf.cutting = 'on' AND mpf.cutting IS NOT NULL AND mpf.process_order_number = ?
)
SELECT 
    MAX(CASE WHEN CheckType = 'Forming' THEN UserName END) AS forming,
    MAX(CASE WHEN CheckType = 'Deburring' THEN UserName END) AS deburring,
    MAX(CASE WHEN CheckType = 'Machining' THEN UserName END) AS machining,
    MAX(CASE WHEN CheckType = 'Cutting' THEN UserName END) AS cutting,
	MAX(CASE WHEN CheckType = 'Identification' THEN UserName END) AS material_identification
FROM 
    LatestChecks
WHERE 
    rn = 1

"
, [$processOrderNumber,$processOrderNumber, $processOrderNumber, $processOrderNumber,$processOrderNumber]);






$data_mat_o=DB::select("SELECT top 8*,
                        case when Type = 'Material Identification Confirm grade, thickness' then 'Material identification' 

                      when Type = 'Machining' then 'Machining' 
                          when Type = 'Forming' then 'Forming'
						   when Type = 'De-burring' then 'Deburring'
						    when Type = 'Cutting Part geometry, cut quality, part qty' then 'Cutting'
							when Type = 'Material Traceability' then 'Material traceability'
                        
                        end[TYPE_NEW]
                        
                        
                                    FROM [QUALITY_PACK].[dbo].[Planning_Owner_Ndt]
                                    WHERE 
									Quality_Step = 'MaterialPrep' and 
									process_order_number=?
                                    ORDER BY created_at DESC
",[$processOrderNumber]);

        $data2 = DB::table('QUALITY_PACK.dbo.Welding_Form_Data as mpf')
            ->where('ProcessOrderID', $processOrderNumber)
            ->join('QUALITY_PACK.dbo.User as u', 'mpf.sign_off_welding_complete', '=', 'u.Login')
            ->orderBy('updated_at', 'desc')
            ->select([ 'ProcessOrderID as process order number',
                'mpf.*',
                DB::raw("CONCAT(u.FirstName, ' ', u.LastName) as sign_off_welding_complete")
            ])
            ->limit(1)
            ->get();

         //  $data3=DB::select() ;

             /* DB::table('QUALITY_PACK.dbo.WeldingCompleteData as mpf')
            ->where('ProcessOrderID', $processOrderNumber)
            ->orderBy('updated_at', 'desc')
            ->join('QUALITY_PACK.dbo.User as u', 'mpf.sign_off_welding_complete', '=', 'u.Login')
            ->select([ 'ProcessOrderID as process order number',
                'mpf.*',
                DB::raw("CONCAT(u.FirstName, ' ', u.LastName) as sign_off_welding_complete")
            ])
            ->limit(1)
            ->get(); */

            $data_2 = DB::select("
            SELECT TOP 1
            mpw.ProcessOrderID [process order number],
            mpw.*,
            CONCAT(u.FirstName, ' ', u.LastName) AS [sign_off_welding_complete],
             
               
                sub.inspection_during_welding AS inspection_during_welding,
                sub.pre_weld_inspection AS pre_weld_inspection,
                sub.post_weld_inspection AS post_weld_inspection
            FROM QUALITY_PACK.dbo.WeldingCompleteData mpw
            LEFT JOIN (
                SELECT 
                    d.ProcessOrderID,
                    MAX(CASE WHEN d.inspection_during_welding = 'on' THEN 1 ELSE 0 END) AS inspection_during_welding,
                    MAX(CASE WHEN d.pre_weld_inspection = 'on' THEN 1 ELSE 0 END) AS pre_weld_inspection,
                    MAX(CASE WHEN d.post_weld_inspection = 'on' THEN 1 ELSE 0 END) AS post_weld_inspection
                FROM QUALITY_PACK.dbo.WeldingCompleteData d
                WHERE d.ProcessOrderID = ?
                GROUP BY d.ProcessOrderID
            ) sub ON mpw.ProcessOrderID = sub.ProcessOrderID
             LEFT JOIN 
                    QUALITY_PACK.dbo.[User] AS u ON u.Login = mpw.sign_off_welding_complete
            WHERE mpw.ProcessOrderID =?
            ORDER BY mpw.updated_at DESC

        ", [$processOrderNumber, $processOrderNumber]);


           $data_2_c =DB::select("WITH LatestChecks AS (
                SELECT 
                    mpf.updated_at,
                    'Pre' AS CheckType,
                    CONCAT(u.FirstName, ' ', u.LastName) AS UserName,
                    ROW_NUMBER() OVER (PARTITION BY mpf.ProcessOrderID ORDER BY mpf.updated_at DESC) AS rn
                FROM 
                    QUALITY_PACK.dbo.WeldingCompleteData AS mpf
                LEFT JOIN 
                    QUALITY_PACK.dbo.[User] AS u ON u.Login = mpf.sign_off_welding_complete
                WHERE 
                    mpf.pre_weld_inspection = 'on' AND mpf.ProcessOrderID = ?
                
                UNION ALL
                
                SELECT 
                    mpf.updated_at,
                    'Post' AS CheckType,
                    CONCAT(u.FirstName, ' ', u.LastName) AS UserName,
                    ROW_NUMBER() OVER (PARTITION BY mpf.ProcessOrderID ORDER BY mpf.updated_at DESC) AS rn
                FROM 
                     QUALITY_PACK.dbo.WeldingCompleteData AS mpf
                LEFT JOIN 
                    QUALITY_PACK.dbo.[User] AS u ON u.Login = mpf.sign_off_welding_complete
                WHERE 
                    mpf.post_weld_inspection = 'on' AND mpf.ProcessOrderID = ?

					   UNION ALL

					       SELECT 
                    mpf.updated_at,
                    'During' AS CheckType,
                    CONCAT(u.FirstName, ' ', u.LastName) AS UserName,
                    ROW_NUMBER() OVER (PARTITION BY mpf.ProcessOrderID ORDER BY mpf.updated_at DESC) AS rn
                FROM 
                     QUALITY_PACK.dbo.WeldingCompleteData AS mpf
                LEFT JOIN 
                    QUALITY_PACK.dbo.[User] AS u ON u.Login = mpf.sign_off_welding_complete
                WHERE 
                    mpf.inspection_during_welding = 'on' AND mpf.ProcessOrderID = ?
            )
            SELECT 
                MAX(CASE WHEN CheckType = 'Pre' THEN UserName END) AS pre_weld_inspection,
                MAX(CASE WHEN CheckType = 'Post' THEN UserName END) AS post_weld_inspection,
				 MAX(CASE WHEN CheckType = 'During' THEN UserName END) AS inspection_during_welding
            FROM 
                LatestChecks
            WHERE 
                rn = 1", [$processOrderNumber, $processOrderNumber,$processOrderNumber]);


/*Welding Owner ,NDT*/

$data_2_o=DB::select("SELECT top 10*,
                        case when Type = 'Weld Map: Weld Map issued to production' then 'Weld map issued' 

                      when Type = 'Weld Procedure Qualification Record:' then 'Weld procedure qualification' 
                          when Type = 'Weld Procedure Specifications:' then 'Weld procedure specifications'
						   when Type = 'Welder Performance Qualification:' then 'Welder performance qualification'
						    when Type = 'Welding Consumable - Welding Wire:' then 'Welding wire'
                        
                        end[TYPE_NEW]
                        
                        
                                    FROM [QUALITY_PACK].[dbo].[Planning_Owner_Ndt]
                                    WHERE Quality_Step = 'Welding' and process_order_number=?
                                    ORDER BY created_at DESC
",[$processOrderNumber]);


        $data3 = DB::table('QUALITY_PACK.dbo.DocumentationFormData as mpf')
            ->where('process_order_number', $processOrderNumber)
            ->join('QUALITY_PACK.dbo.User as u', 'mpf.engineer', '=', 'u.Login')
            ->orderBy('updated_at', 'desc')
            ->select([ 'process_order_number',
            
                'mpf.*',
               
                DB::raw("CONCAT(u.FirstName, ' ', u.LastName) as engineer")
            ])
            ->limit(1)
            ->get();

        $data_3 = DB::table('QUALITY_PACK.dbo.DocumentationCompleteData as mpf')
            ->where('process_order_number', $processOrderNumber)
            ->join('QUALITY_PACK.dbo.User as u', 'mpf.sign_off_documentation', '=', 'u.Login')
            //->select('*','sign_off_documentation as engineer')
            ->select([ 'process_order_number','mpf.technical_file as technical_file_check','mpf.client_handover_documentation as client_handover_check',
            DB::raw("FORMAT(mpf.updated_at, 'dd/MM/yyyy HH:mm') AS updated_at"),
            DB::raw("FORMAT(mpf.created_at, 'dd/MM/yyyy HH:mm') AS created_at"),
                DB::raw("CONCAT(u.FirstName, ' ', u.LastName) as engineer")
            ])
            ->orderBy('updated_at', 'desc')
            ->limit(1)
            ->get();



            /* documentation */
            $data_3_o=DB::select("SELECT top 2
*,
case when Type = 'Client Hand-over documentation:' then 'Client handover check' 
 when Type = 'Technical File:' then 'Technical file check' 




end [TYPE_NEW]
            FROM [QUALITY_PACK].[dbo].[Planning_Owner_Ndt]
            WHERE Quality_Step = 'Documentation' and process_order_number=?
            ORDER BY created_at DESC
",[$processOrderNumber]);

            


        $data4 = DB::table('QUALITY_PACK.dbo.TestingFormDatas as mpf')
            ->where('process_order_number', $processOrderNumber)
            ->join('QUALITY_PACK.dbo.User as u', 'mpf.sign_off_testing', '=', 'u.Login')
            ->orderBy('updated_at', 'desc')
            ->select([ 'process_order_number',
                'mpf.*',
                DB::raw("CONCAT(u.FirstName, ' ', u.LastName) as sign_off_testing")
            ])
            ->limit(1)
            ->get();

            $data_4 =/*  DB::table('QUALITY_PACK.dbo.TestingCompleteData as mpf')
            ->where('process_order_number', $processOrderNumber)
            ->join('QUALITY_PACK.dbo.User as u', 'mpf.sign_off', '=', 'u.Login')
            ->orderBy('mpf.updated_at', 'desc')
            ->select([
                'mpf.process_order_number',
                'mpf.dye_pen_testing as dye_pen_test',
                'mpf.hydrostatic_testing as hydrostatic_test',
                'mpf.pneumatic_testing as pneumatic_test',
                'mpf.fat_protocoll as fat_protocol',
                DB::raw("CONCAT(u.FirstName, ' ', u.LastName) as sign_off_testing"),
                'mpf.*',
            ])
            ->limit(1)
            ->get(); */



           DB::select("SELECT TOP 1
            mpw.process_order_number,
            mpw.*,
            CONCAT(u.FirstName, ' ', u.LastName) AS [sign_off_welding_complete],
             
               
                sub.pneumatic_test AS pneumatic_test,
                sub.dye_pen_test AS dye_pen_test,
                sub.fat_protocol AS fat_protocol,
				sub.hydrostatic_test AS hydrostatic_test
            FROM QUALITY_PACK.dbo.TestingCompleteData mpw
            LEFT JOIN (
                SELECT 
                    d.process_order_number,
                    MAX(CASE WHEN d.pneumatic_testing = 'on' THEN 1 ELSE 0 END) AS pneumatic_test,
                    MAX(CASE WHEN d.dye_pen_testing = 'on' THEN 1 ELSE 0 END) AS dye_pen_test,
                    MAX(CASE WHEN d.fat_protocoll = 'on' THEN 1 ELSE 0 END) AS fat_protocol,
					   MAX(CASE WHEN d.hydrostatic_testing = 'on' THEN 1 ELSE 0 END) AS hydrostatic_test
                FROM QUALITY_PACK.dbo.TestingCompleteData d
                WHERE d.process_order_number = ?
                GROUP BY d.process_order_number
            ) sub ON mpw.process_order_number = sub.process_order_number
             LEFT JOIN 
                    QUALITY_PACK.dbo.[User] AS u ON u.Login = mpw.sign_off
            WHERE mpw.process_order_number =?
            ORDER BY mpw.updated_at DESC", [$processOrderNumber, $processOrderNumber]);



$data_4_c=DB::select("WITH LatestChecks AS (
    SELECT 
                        mpf.updated_at,
                        'Dye' AS CheckType,
                        CONCAT(u.FirstName, ' ', u.LastName) AS UserName,
                        ROW_NUMBER() OVER (PARTITION BY mpf.process_order_number ORDER BY mpf.updated_at DESC) AS rn
                    FROM 
                        QUALITY_PACK.dbo.TestingCompleteData AS mpf
                    LEFT JOIN 
                        QUALITY_PACK.dbo.[User] AS u ON u.Login = mpf.sign_off
                    WHERE
                        mpf.dye_pen_testing = 'on' AND mpf.process_order_number = ?
                        UNION ALL
                    SELECT 
                        mpf.updated_at,
                        'Hydro' AS CheckType,
                        CONCAT(u.FirstName, ' ', u.LastName) AS UserName,
                        ROW_NUMBER() OVER (PARTITION BY mpf.process_order_number ORDER BY mpf.updated_at DESC) AS rn
                    FROM 
                        QUALITY_PACK.dbo.TestingCompleteData AS mpf
                    LEFT JOIN 
                        QUALITY_PACK.dbo.[User] AS u ON u.Login = mpf.sign_off
                    WHERE 
                        mpf.hydrostatic_testing = 'on' AND mpf.process_order_number = ?
                    
                    UNION ALL
                    
                    SELECT 
                        mpf.updated_at,
                        'Pneumatic' AS CheckType,
                        CONCAT(u.FirstName, ' ', u.LastName) AS UserName,
                        ROW_NUMBER() OVER (PARTITION BY mpf.process_order_number ORDER BY mpf.updated_at DESC) AS rn
                    FROM 
                         QUALITY_PACK.dbo.TestingCompleteData AS mpf
                    LEFT JOIN 
                        QUALITY_PACK.dbo.[User] AS u ON u.Login = mpf.sign_off
                    WHERE 
                        mpf.pneumatic_testing = 'on' AND mpf.process_order_number = ?
    
                           UNION ALL
    
                               SELECT 
                        mpf.updated_at,
                        'fat' AS CheckType,
                        CONCAT(u.FirstName, ' ', u.LastName) AS UserName,
                        ROW_NUMBER() OVER (PARTITION BY mpf.process_order_number ORDER BY mpf.updated_at DESC) AS rn
                    FROM 
                         QUALITY_PACK.dbo.TestingCompleteData AS mpf
                    LEFT JOIN 
                        QUALITY_PACK.dbo.[User] AS u ON u.Login = mpf.sign_off
    
                    WHERE 
                        mpf.fat_protocoll = 'on' AND mpf.process_order_number = ?
                )
                SELECT 
                    MAX(CASE WHEN CheckType = 'Dye' THEN UserName END) AS dye_pen_test,
                    MAX(CASE WHEN CheckType = 'Pneumatic' THEN UserName END) AS pneumatic_test,
                     MAX(CASE WHEN CheckType = 'fat' THEN UserName END) AS fat_protocol,
                     MAX(CASE WHEN CheckType = 'Hydro' THEN UserName END) AS hydrostatic_test
                FROM 
                    LatestChecks
                WHERE 
                    rn = 1",[$processOrderNumber, $processOrderNumber,$processOrderNumber,$processOrderNumber]);




$data_4_o=DB::select("SELECT top 4*,
case when Type = 'FAT' then 'Fat protocol' 
 when Type = 'Dye Penetrant Procedure' then 'Dye pen test' 
 when Type = 'Hydrostatic Leak Test' then 'Hydrostatic test' 
 when Type = 'Pneumatic Leak Test' then 'Pneumatic test' 



end [TYPE_NEW]
            FROM [QUALITY_PACK].[dbo].[Planning_Owner_Ndt]
            WHERE Quality_Step = 'Testing' and process_order_number=?
            ORDER BY created_at DESC
",[$processOrderNumber]);

        
        $data5 = DB::table('QUALITY_PACK.dbo.KittingFormData as mpf')
            ->where('ProcessOrderID', $processOrderNumber)
            ->join('QUALITY_PACK.dbo.User as u', 'mpf.sign_off_kitting', '=', 'u.Login')
            ->orderBy('updated_at', 'desc')
            ->select([ 'ProcessOrderID as process order number',
                'mpf.*',
                DB::raw("CONCAT(u.FirstName, ' ', u.LastName) as sign_off_kitting")
            ])
            ->limit(1)
            ->get();

        $data_5 = DB::table('QUALITY_PACK.dbo.KittingFormCompleteData as mpf')
            ->where('ProcessOrderID', $processOrderNumber)
            ->join('QUALITY_PACK.dbo.User as u', 'mpf.sign_off_kitting', '=', 'u.Login')
            ->orderBy('updated_at', 'desc')
            ->select([ 'ProcessOrderID  as process order number',
                'mpf.*',
                DB::raw("CONCAT(u.FirstName, ' ', u.LastName) as sign_off_kitting")
            ])
            ->limit(1)
            ->get();


            $data_5_o=DB::select("SELECT top 5
*,
case when Type = 'Cut Formed Machine Parts Details about cutting formed machine parts' then 'Cut form mach parts' 



end [TYPE_NEW]
            FROM [QUALITY_PACK].[dbo].[Planning_Owner_Ndt]
            WHERE Quality_Step = 'Kitting' and process_order_number=?
            ORDER BY created_at DESC
",[$processOrderNumber]);


        $data6 = DB::table('QUALITY_PACK.dbo.PackingTransportFormData as mpf')
            ->where('process_order_number', $processOrderNumber)
            ->join('QUALITY_PACK.dbo.User as u', 'mpf.engineer', '=', 'u.Login')
            ->orderBy('updated_at', 'desc')
            ->select([ 'process_order_number',
                'mpf.*',
                DB::raw("CONCAT(u.FirstName, ' ', u.LastName) as sign_off_transport")
            ])
            ->limit(1)
            ->get();

        $data_6 = DB::table('QUALITY_PACK.dbo.PackingTransportCompleteData as mpf')
            ->where('process_order_number', $processOrderNumber)
            ->join('QUALITY_PACK.dbo.User as u', 'mpf.sign_off_documentation', '=', 'u.Login')
            ->orderBy('updated_at', 'desc')
            ->select('*','sign_off_documentation as resp_person')
            ->select([ 'process_order_number',
                'mpf.*',
                DB::raw("CONCAT(u.FirstName, ' ', u.LastName) as sign_off_transport")
            ])
            ->limit(1)
            ->get();

            

                        $data_6_o=DB::select("SELECT top 1*,
                        case when Type = 'Secure Packing:' then 'Secure packing' 
                        
                         
                        
                        end[TYPE_NEW]
                        
                        
                                    FROM [QUALITY_PACK].[dbo].[Planning_Owner_Ndt]
                                    WHERE Quality_Step = 'Transport' and process_order_number=?
                                    ORDER BY created_at DESC
                        ",[$processOrderNumber]); 
                        

            $data_qlty = DB::table('QUALITY_PACK.dbo.QualityFormData as mpf')
            ->where('process_order_number', $processOrderNumber)
            ->join('QUALITY_PACK.dbo.User as u', 'mpf.sign_off_quality', '=', 'u.Login')
            ->orderBy('updated_at', 'desc')
            ->select([ 'process_order_number',
                'mpf.*',
                DB::raw("CONCAT(u.FirstName, ' ', u.LastName) as sign_off_quality")
            ])
            ->limit(1)
            ->get();

        $data_qlty_c = DB::table('QUALITY_PACK.dbo.QualityCompleteData as mpf')
            ->where('process_order_number', $processOrderNumber)
            ->join('QUALITY_PACK.dbo.User as u', 'mpf.sign_off_quality', '=', 'u.Login')
            ->orderBy('updated_at', 'desc')
            ->select([ 'process_order_number',
                'mpf.*',
                DB::raw("CONCAT(u.FirstName, ' ', u.LastName) as sign_off_quality")
            ])
           
            ->limit(1)
            ->get();



            $data_qlty_o=DB::select("SELECT top 1*,
case when Type = 'Walk-down and Visual Inspection' then 'Walk down visual inspection' 


end [TYPE_NEW]
            FROM [QUALITY_PACK].[dbo].[Planning_Owner_Ndt]
            WHERE Quality_Step = 'Quality' and process_order_number=?
            ORDER BY created_at DESC
            ",[$processOrderNumber]);
            $data_final = DB::table('QUALITY_PACK.dbo.FinalAssemblyFormData as mpf')
            ->where('process_order_number', $processOrderNumber)
            ->join('QUALITY_PACK.dbo.User as u', 'mpf.sign_off_final_assembly', '=', 'u.Login')
            ->orderBy('updated_at', 'desc')
            ->select([ 'process_order_number',
                'mpf.*',
                DB::raw("CONCAT(u.FirstName, ' ', u.LastName) as sign_off_final_assembly")
            ])
            ->limit(1)
            ->get();

        $data_final_c = DB::table('QUALITY_PACK.dbo.FinalAssemblyCompleteData as mpf')
            ->where('process_order_number', $processOrderNumber)
            ->join('QUALITY_PACK.dbo.User as u', 'mpf.sign_off_final_assembly', '=', 'u.Login')
            ->orderBy('updated_at', 'desc')
            ->select([ 'process_order_number',
                'mpf.*',
                DB::raw("CONCAT(u.FirstName, ' ', u.LastName) as sign_off_final_assembly")
            ])
           
            ->limit(1)
            ->get();

            $data_final_o=DB::select("SELECT top 1*,
            case when Type = 'Attach Part ID Labels / Name Plates:' then 'Identification' 
            
            
            end [TYPE_NEW]
                        FROM [QUALITY_PACK].[dbo].[Planning_Owner_Ndt]
                        WHERE Quality_Step = 'Final' and process_order_number=?
                        ORDER BY created_at DESC
            ",[$processOrderNumber]);
            

            $data_finishing = DB::table('QUALITY_PACK.dbo.FinishingFormData as mpf')
            ->where('process_order_number', $processOrderNumber)
            ->join('QUALITY_PACK.dbo.User as u', 'mpf.sign_off_finishing', '=', 'u.Login')
            ->orderBy('updated_at', 'desc')
            ->select([ 'process_order_number',
                'mpf.*',
                DB::raw("CONCAT(u.FirstName, ' ', u.LastName) as sign_off_finishing")
            ])
            ->limit(1)
            ->get();

        $data_finishing_c = /* DB::table('QUALITY_PACK.dbo.FinishingCompleteData')
            ->where('process_order_number', $processOrderNumber)
            ->orderBy('updated_at', 'desc')
          
            ->limit(1)
            ->get(); */


           
            DB::table('QUALITY_PACK.dbo.FinishingCompleteData AS mpt')
            ->join('QUALITY_PACK.dbo.User AS u', 'u.Login', '=', 'mpt.sign_off_finishing')
            ->leftJoin(DB::raw("
                (SELECT 
                    mpf.process_order_number,
                    MAX(CASE WHEN mpf.pickle_passivate_test = '1' THEN 1 ELSE 0 END) AS pickle_passivate_test,
                    MAX(CASE WHEN mpf.select_kent_finish_test = '1' THEN 1 ELSE 0 END) AS select_kent_finish_test
                FROM 
                    QUALITY_PACK.dbo.FinishingCompleteData AS mpf
               
                WHERE 
                    mpf.process_order_number = $processOrderNumber
                GROUP BY 
                    mpf.process_order_number
                ) AS sub"), 'mpt.process_order_number', '=', 'sub.process_order_number')
            ->where('mpt.process_order_number', '=', $processOrderNumber)
            ->select([
                'mpt.*',
                'sub.pickle_passivate_test',
                'sub.select_kent_finish_test'
            ])
            ->limit(1)
            ->get();

            $data_finishing_cc=DB::select("WITH LatestChecks AS (
                SELECT 
                    mpf.updated_at,
                    'Pickle Passivate' AS CheckType,
                    CONCAT(u.FirstName, ' ', u.LastName) AS UserName,
                    ROW_NUMBER() OVER (PARTITION BY mpf.process_order_number ORDER BY mpf.updated_at DESC) AS rn
                FROM 
                    QUALITY_PACK.dbo.FinishingCompleteData AS mpf
                LEFT JOIN 
                    QUALITY_PACK.dbo.[User] AS u ON u.Login = mpf.sign_off_finishing
                WHERE 
                    mpf.pickle_passivate_test = '1' AND mpf.process_order_number = ?
                
                UNION ALL
                
                SELECT 
                    mpf.updated_at,
                    'Select Kent Finish' AS CheckType,
                    CONCAT(u.FirstName, ' ', u.LastName) AS UserName,
                    ROW_NUMBER() OVER (PARTITION BY mpf.process_order_number ORDER BY mpf.updated_at DESC) AS rn
                FROM 
                    QUALITY_PACK.dbo.FinishingCompleteData AS mpf
                LEFT JOIN 
                    QUALITY_PACK.dbo.[User] AS u ON u.Login = mpf.sign_off_finishing
                WHERE 
                    mpf.select_kent_finish_test = '1' AND mpf.process_order_number = ?
            )
            SELECT 
                MAX(CASE WHEN CheckType = 'Pickle Passivate' THEN UserName END) AS pickle_passivate_test,
                MAX(CASE WHEN CheckType = 'Select Kent Finish' THEN UserName END) AS select_kent_finish_test
            FROM 
                LatestChecks
            WHERE 
                rn = 1", [$processOrderNumber, $processOrderNumber]);



$data_finishing_o=DB::select("SELECT top 2*,
case when Type = 'Pickle and Passivate:' then 'Pickle passivate test' 


end [TYPE_NEW]
            FROM [QUALITY_PACK].[dbo].[Planning_Owner_Ndt]
            WHERE Quality_Step = 'Finishing' and process_order_number=?
            ORDER BY created_at DESC
",[$processOrderNumber]);


            $data_fabfit = /* DB::table('QUALITY_PACK.dbo.FabricationFitUpFormData')
            ->where('ProcessOrder', $processOrderNumber)
            ->orderBy('updated_at', 'desc')
            
            ->limit(1)
            ->get(); */
            DB::select ("select top 1  [ProcessOrder] as Process_Order,
            [FitUpVisualCheck] as FitUpVisualCheck,[DimensionalCheck]DimensionalCheck,[WeldmentQuantity] as [Weld Check],[LinkToDrawing],[Status],[Quantity],[SignOffUser] as Sign_off_user,[Comments],[updated_at],[created_at]
        FROM [QUALITY_PACK].[dbo].[FabricationFitUpFormData] where ProcessOrder=? order by updated_at DESC"
      , [$processOrderNumber]);
      
           
        $data_fabfit_c = /* DB::table('QUALITY_PACK.dbo.FabricationFitUpCompleteData')
            ->where('ProcessOrder', $processOrderNumber)
            ->orderBy('updated_at', 'desc')
          
            ->limit(1)
            ->get(); */
            /* DB::select ("select top 1
            [FitUpVisualCheck] as FitUpVisualCheck,[DimensionalCheck]DimensionalCheck,[WeldmentQuantity] as [Weld Check],[LinkToDrawing],[Status],[Quantity],[SignOffUser] as Sign_off_user,[Comments],[ProcessOrder]as Process_Order,[updated_at],[created_at]
        FROM [QUALITY_PACK].[dbo].[FabricationFitUpCompleteData] where ProcessOrder=? order by updated_at DESC"
      , [$processOrderNumber]); */

   DB::select ("select top 1 mpf.ProcessOrder as Process_Order,
            sub.FitUpVisualCheck as FitUpVisualCheck,sub.DimensionalCheck as DimensionalCheck,sub.WeldmentQuantity as [Weld Check],[LinkToDrawing],[Status],[Quantity],[SignOffUser] as Sign_off_user,[Comments],updated_at,created_at
        FROM [QUALITY_PACK].[dbo].[FabricationFitUpCompleteData] mpf
      
 left join (select d.ProcessOrder,
            MAX(CASE WHEN  d.DimensionalCheck='1' THEN 1 ELSE NULL END) AS DimensionalCheck,
            
            MAX(CASE WHEN d.FitUpVisualCheck='1' THEN 1 ELSE NULL END) AS FitUpVisualCheck,
          
            MAX(CASE WHEN d.WeldmentQuantity='1'  THEN 1 ELSE NULL END) AS WeldmentQuantity
            
           
        FROM QUALITY_PACK.dbo.FabricationFitUpCompleteData d
        GROUP BY d.ProcessOrder
        )sub on mpf.ProcessOrder=sub.ProcessOrder
	 where sub.ProcessOrder=? order by updated_at DESC"
      , [$processOrderNumber]); 
      $data_fabfit_cc = DB::select("
    WITH LatestChecks AS (
        SELECT 
            mpf.updated_at,
            'FitUpVisualCheck' AS CheckType,
            CONCAT(U.FirstName, ' ', U.LastName) AS UserName,
            ROW_NUMBER() OVER (PARTITION BY mpf.ProcessOrder ORDER BY mpf.updated_at DESC) AS rn
        FROM 
            QUALITY_PACK.dbo.FabricationFitUpCompleteData AS mpf
        LEFT JOIN 
            QUALITY_PACK.dbo.[User] AS U ON U.Login = mpf.fitupvisualcheck_person
        WHERE 
            ISNUMERIC(mpf.FitUpVisualCheck) = 1 AND mpf.FitUpVisualCheck != 0 AND mpf.ProcessOrder = ?
        
        UNION ALL
        
        SELECT 
            mpf.updated_at,
            'WeldmentQuantity' AS CheckType,
            CONCAT(U.FirstName, ' ', U.LastName) AS UserName,
            ROW_NUMBER() OVER (PARTITION BY mpf.ProcessOrder ORDER BY mpf.updated_at DESC) AS rn
        FROM 
            QUALITY_PACK.dbo.FabricationFitUpCompleteData AS mpf
        LEFT JOIN 
            QUALITY_PACK.dbo.[User] AS U ON U.Login = mpf.weldcheck_person
        WHERE 
            ISNUMERIC(mpf.WeldmentQuantity) = 1 AND mpf.WeldmentQuantity != 0 AND mpf.ProcessOrder = ?
        
        UNION ALL
        
        SELECT 
            mpf.updated_at,
            'DimensionalCheck' AS CheckType,
            CONCAT(U.FirstName, ' ', U.LastName) AS UserName,
            ROW_NUMBER() OVER (PARTITION BY mpf.ProcessOrder ORDER BY mpf.updated_at DESC) AS rn
        FROM 
            QUALITY_PACK.dbo.FabricationFitUpCompleteData AS mpf
        LEFT JOIN 
            QUALITY_PACK.dbo.[User] AS U ON U.Login = mpf.dimensionalcheck_person
        WHERE 
            ISNUMERIC(mpf.DimensionalCheck) = 1 AND mpf.DimensionalCheck != 0 AND mpf.ProcessOrder = ?
    )
    SELECT 
        MAX(CASE WHEN CheckType = 'FitUpVisualCheck' THEN UserName END) AS FitUpVisualCheck,
        MAX(CASE WHEN CheckType = 'WeldmentQuantity' THEN UserName END) AS [Weld Check],
        MAX(CASE WHEN CheckType = 'DimensionalCheck' THEN UserName END) AS DimensionalCheck
    FROM 
        LatestChecks
    WHERE 
        rn = 1
", [$processOrderNumber, $processOrderNumber, $processOrderNumber]);

$data_fabfit_o=DB::select("SELECT top 4*,
case when Type = 'SUB CON ACTION:0' then 'LinkToDrawing' 

 when Type='Weld Check'then 'Weld Check'
when Type='Dimensional check: Dimensional check first off'then 'DimensionalCheck'
 when Type='Fit-up: Visual check fit up - first off'then 'FitUpVisualCheck'

end[TYPE_NEW]


            FROM [QUALITY_PACK].[dbo].[Planning_Owner_Ndt]
            WHERE Quality_Step = 'Fabrication' and process_order_number=?
            ORDER BY created_at DESC
",[$processOrderNumber]); 



            $data_subcontract = DB::table('QUALITY_PACK.dbo.subcontractFormData as mpf')
            ->where('process_order_number', $processOrderNumber)
            ->orderBy('updated_at', 'desc')
            ->join('QUALITY_PACK.dbo.User as u', 'mpf.sign_off_sub_contract', '=', 'u.Login')
            ->select([ 'process_order_number',
                'mpf.*',
                DB::raw("CONCAT(u.FirstName, ' ', u.LastName) as sign_off_sub_contract")
            ])
            ->limit(1)
            ->get();

        $data_subcontract_c = DB::table('QUALITY_PACK.dbo.subcontractCompleteData as mpf')
            ->where('process_order_number', $processOrderNumber)
            ->join('QUALITY_PACK.dbo.User as u', 'mpf.sign_off_sub_contract', '=', 'u.Login')
            ->orderBy('updated_at', 'desc')
            ->select([ 'process_order_number',
                'mpf.*',
                DB::raw("CONCAT(u.FirstName, ' ', u.LastName) as sign_off_sub_contract")
            ])
           
            ->limit(1)
            ->get();

$data_subcontract_o=DB::select("SELECT top 2*,
case when Type = 'SUB CON ACTION:0' then 'Sub contract action' end[TYPE_NEW]


            FROM [QUALITY_PACK].[dbo].[Planning_Owner_Ndt]
            WHERE Quality_Step = 'Subcontract' and process_order_number=?
            ORDER BY created_at DESC
",[$processOrderNumber]); 



            $data_engineering = DB::table('QUALITY_PACK.dbo.EngineeringFormData as mpf')
            ->where('process_order_number', $processOrderNumber)
            ->join('QUALITY_PACK.dbo.User as u', 'mpf.sign_off_engineering', '=', 'u.Login')
            ->orderBy('updated_at', 'desc')
            ->select([ 'process_order_number',
                'mpf.*',
                DB::raw("CONCAT(u.FirstName, ' ', u.LastName) as sign_off_engineering")
            ])
            ->limit(1)
            ->get();
            $data_engineering_c = DB::table('QUALITY_PACK.dbo.EngineeringFormData as mpf')
            ->where('process_order_number', $processOrderNumber)
            ->join('QUALITY_PACK.dbo.User as u', 'mpf.sign_off_engineering', '=', 'u.Login')
            ->orderBy('updated_at', 'desc')
            ->select([ 'process_order_number',
                'mpf.updated_at',
                DB::raw("CONCAT(u.FirstName, ' ', u.LastName) as sign_off_engineering"),
                DB::raw("CONCAT(u.FirstName, ' ', u.LastName) as reference_job_master_file"),
                DB::raw("CONCAT(u.FirstName, ' ', u.LastName) as reference_approved_samples"),
            ])
            ->limit(1)
            ->get();

            $data_engineering_o=DB::select("SELECT top 7*,
case when Type = 'Customer submittal package' then 'Customer approval document' 
when Type='Reference Job / Master File if applicable' then 'Reference job master file'
 when Type='Reference approved samples' then 'Reference approved samples'
 when Type='Concept design & engineering details' then 'Concept design engineering'

 when Type='Design sign off [calculations]'then 'Design validation sign off'

end [TYPE_NEW]
            FROM [QUALITY_PACK].[dbo].[Planning_Owner_Ndt]
            WHERE Quality_Step = 'Engineering' and process_order_number=?
            ORDER BY created_at DESC
",[$processOrderNumber]);

            

        $data_manufacturing= DB::table('QUALITY_PACK.dbo.ManufacturingFormData as mpf')
            ->where('process_order_number', $processOrderNumber)
            ->join('QUALITY_PACK.dbo.User as u', 'mpf.sign_off_manufacturing', '=', 'u.Login')
            ->orderBy('updated_at', 'desc')
            ->select([ 'process_order_number',
                'mpf.*',
                DB::raw("CONCAT(u.FirstName, ' ', u.LastName) as sign_off_manufacturing")
            ])
            ->limit(1)
            ->get();

            $data_manufacturing_o=DB::select("SELECT top 5*,
            case when Type = 'Machine Programming Files' then 'Machine programming files' 

          when Type = 'NDT Documentation' then 'Ndt documentation' 
              when Type = 'Quality documents' then 'Quality documents'
               when Type = 'BOM' then 'Bom'
                when Type = 'Production Drawings' then 'Production drawings'
            
            end[TYPE_NEW]
            
            
                        FROM [QUALITY_PACK].[dbo].[Planning_Owner_Ndt]
                        WHERE Quality_Step = 'Manufacturing' and process_order_number=?
                        
                        ORDER BY created_at DESC
",[$processOrderNumber]);



            $data_planning = DB::table('QUALITY_PACK.dbo.PlanningFormData as mpf')
            ->where('process_order_number', $processOrderNumber)
            ->join('QUALITY_PACK.dbo.User as u', 'mpf.sign_off_planning', '=', 'u.Login')
            ->select([
                'process_order_number',
                'mpf.*',
                DB::raw("CONCAT(u.FirstName, ' ', u.LastName) as sign_off_planning")
            ])
            ->orderBy('updated_at', 'desc')
            ->limit(1)
            ->get();


            $data_planning_o=DB::select("SELECT top 5*,
case when Type = 'Project risk category assessment' then 'Project risk category assessment' 
when Type='Verify customer expectations' then 'Verify customer expectations'
 when Type='Quotation' then 'Quotation'
 when Type='Project schedule agreed' then 'Project schedule agreed'

 when Type='Purchase Order received'then 'Purchase order received'

end [TYPE_NEW]
            FROM [QUALITY_PACK].[dbo].[Planning_Owner_Ndt]
            WHERE Quality_Step = 'Planning' and process_order_number=?
            ORDER BY created_at DESC
",[$processOrderNumber]);







        $sql="select
  distinct t0.DocNum [SalesOrder],
  t0.CardName [Customer],
  t7.PrOrder [ProcessOrder],
  CAST(t7.Batchsize AS DECIMAL(18, 2)) AS [Quantity],
  t7.EndProduct [EndProduct],
  t2.SlpName [Engineer],
  t_3.ItemName

from
Kentstainless.dbo.iis_epc_pro_orderh t7
inner join KENTSTAINLESS.dbo.oitm t_3 on t_3.itemcode = t7.EndProduct
---inner join KENTSTAINLESS.dbo.oitb t_4 on t_4.ItmsGrpCod = t_3.ItmsGrpCod
  left join Kentstainless.dbo.ordr t0 on t0.DocNum = t7.SONum
  LEFT JOIN Kentstainless.dbo.rdr1 t3 ON t3.DocEntry = t0.DocEntry
  INNER JOIN Kentstainless.dbo.ohem t1 ON t1.empID = t0.OwnerCode
  INNER JOIN Kentstainless.dbo.oslp t2 ON t2.SlpCode = t0.SlpCode
  INNER JOIN Kentstainless.dbo.ocrd t4 ON t4.CardCode = t0.CardCode

 where  t7.PrOrder = ?
";
        // Execute the query
$result = DB::select($sql, [$processOrderNumber]);

// Check if there are any results
if (!empty($result)) {
    // Get the first item
    $data_sales= $result[0];
} else {
    $data_sales= null;
}



        // Pass data to the view
        $pdf = PDF::loadView('reportpdf', compact('data1', 'data_1','data_11','data2','data_2','data_2_c','data_2_o','data3','data_3','data_3_o','data4','data_4','data_4_c','data_4_o','data5','data_5', 'data_5_o','data6','data_6','data_6_o','data_qlty','data_qlty_c','data_qlty_o','data_planning','data_planning_o','data_finishing','data_finishing_c','data_fabfit','data_fabfit_c','data_fabfit_cc','data_fabfit_o','data_subcontract','data_subcontract_c','data_subcontract_o','data_engineering','data_engineering_c','data_engineering_o','data_manufacturing','data_manufacturing_o','data_sales','data_finishing','data_finishing_c','data_finishing_o','data_finishing_cc','data_final','data_final_c','data_final_o'));

        // Return the PDF for download
   // return $pdf->download('material_preparation_data.pdf');
      // return view('reportpdf');
      return view('reportpdf', compact('data1', 'data_1' ,'data_11','data2', 'data_2', 'data_2_c','data_2_o','data3', 'data_3', 'data_3_o','data4', 'data_4', 'data_4_o','data_4_c','data5', 'data_5_o','data_5','data6','data_6','data_6_o','data_qlty','data_qlty_c','data_qlty_o','data_planning','data_planning_o','data_finishing','data_finishing_c','data_fabfit','data_fabfit_c','data_fabfit_cc','data_fabfit_o','data_subcontract','data_subcontract_c','data_subcontract_o','data_engineering','data_engineering_c','data_engineering_o','data_manufacturing','data_manufacturing_o','data_sales','data_finishing','data_finishing_c','data_finishing_cc','data_finishing_o','data_final','data_final_c','data_final_o'));
    }
}