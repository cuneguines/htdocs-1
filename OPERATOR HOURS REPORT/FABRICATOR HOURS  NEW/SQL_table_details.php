<?php
try{
    // CONNECT TO SEVER WITH PDO SQL SERVER FUNCTION
    $conn = new PDO("sqlsrv:Server=KPTSVSP;Database=KENTSTAINLESS","sa","SAPB1Admin");
    // CREATE QUERY EXECUTION FUNCTION
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(Exception $e){
    // REPORT ERROR
    die(print_r($e->getMessage()));
}
//$Id = (!empty($_POST['id']) ? $_POST['id'] : '');
try{
$results_old="  select   t1.OriginNum [Sales Order],  t0.PrOrder [Process Order], 

(case when t0.Status = 'C' then 'Closed'
when t0.Status in ('I','S') then 'Open' else 'Cancelled' end) [Status],  
t6.ItemName, 
t5.CardName [Customer],t5.U_Client [Project], 

t0.[EndProduct],
t17.ItmsGrpNam,
t6.U_Product_Group_One,
t6.U_Product_Group_Two,
t6.U_Product_Group_Three,

---t12.[Last Hour Booked], 
FORMAT(t12.[Last Hour Booked], 'dd/MM/yyyy' ) AS [Last Hour Booked],
 FORMAT(t0.CreateDate, 'dd/MM/yyyy') AS CreateDate,
YEAR(t0.CreateDate) AS [Year_Cr],
    MONTH(t0.CreateDate) AS [Month_Cr],
    DATEPART(WEEK, t1.CreateDate) AS [Week_Cr],
 FORMAT(t1.CloseDate, 'dd/MM/yyyy') AS CloseDate,
  YEAR(t1.CloseDate) AS [Year_Cl],
    MONTH(t1.CloseDate) AS [Month_Cl],
    DATEPART(WEEK, t1.CloseDate) AS [Week_Cl],
t1.PlannedQty[QTY],
isnull(t9.Planned_Lab,0) [Total Planned Time],


t1_H.Actual_Lab[TOTAL_BOOKED_HRS],

isnull(t9.Planned_Lab,0)-(COALESCE(t11.[DYE-PEN TESTING],0)+
COALESCE(t11.[ELECTRO-POLISHING LABOUR],0)+
COALESCE(t11.[ELECTRO-POLISHING MACHINE],0)+
COALESCE(t11.[FABRICATION CARBON STEEL],0)+
COALESCE(t11.[FABRICATION DRAINAGE],0)+
COALESCE(t11.[FABRICATION MACHINE BUILD],0)+
COALESCE(t11.[FABRICATION MACHINING],0)+
COALESCE(t11.[FABRICATION MACHINING],0)+
COALESCE(t11.[FABRICATION STAINLESS FURNITURE],0)+
COALESCE(t11.[FINAL ASSEMBLY],0)+
COALESCE(t11.[FINISH POLISHING],0)+
COALESCE(t11.[HYDROSTATIC TESTING],0)+
COALESCE(t11.[KITTING],0)+
COALESCE(t11.[LASER LABOUR],0)+
COALESCE(t11.[LASER MACHINE],0)+
COALESCE(t11.[Laser/Saw Programming],0)+
COALESCE(t11.[MECHANICAL ELECTRICAL OR OTHER TESTING],0)+
COALESCE(t11.[MILLING/MACHINING/CNC],0)+
COALESCE(t11.[PACKAGING HOURS],0)+
COALESCE(t11.[PICKLE & PASSIVATE],0)+
COALESCE(t11.POLISHING,0)+
COALESCE(t11.[Product Handover documentation and manuals],0)+
COALESCE(t11.[Quality Check],0)+
COALESCE(t11.[Quality Release and customer documentation],0)+
COALESCE(t11.[ROBOTIC WELDING LABOUR],0)+
COALESCE(t11.[ROBOTIC WELDING TRUMPF],0)+
COALESCE(t11.[SAW],0)+
COALESCE(t11.[SITE WORK],0)+
COALESCE(t11.[STAMPING AND MINOR ASSEMBLY],0)+
COALESCE(t11.[SUBCONTRACT],0)+
COALESCE(t11.[WRAPPING],0) +
COALESCE(t11.[DEBUR & POLISH],0)+
COALESCE(t11.[BEAD BLAST LABOUR],0)+
COALESCE(t11.[BEAD BLAST MACHINE],0)+
COALESCE(t11.[3RD PARTY FAT INSPECTION],0)+
COALESCE(t11.[DEBUR/TIME SAVER],0)+
COALESCE(t11.[BRAKE PRESS],0)+COALESCE(t11.[Non Chargeable Time],0)
) as [Delta],
isnull(t10.Actual_Lab/t9.Planned_Lab,0) [Labour Efficiency],   
isnull(t4.Actual_Fab/t3.Planned_Fab,0) [Fabrication Efficiency],  
--case when t0.status = 'C' then 'C' else t33.status end [Status],
t1234.[Planned Laser/Saw Hrs],
t11.[Laser/Saw Programming],
---LAaser MAchine---

t1234.[Planned Laser M Hrs]*60 as [Planned Time Minutes Laser Machine],
t11.[LASER MACHINE]*60 as [Booked time Minutes Laser Machine],
'' as [Comments Laser Machine],
case when t0.status = 'C' then 'C' else t33.status end [Process Order Step Laser Machine],
case when t33.Status='C' then t33_LM.LineID end  [Last hour Laser Machine ],
t11.[LASER MACHINE][LASER Machine Booked Hours],
t1234.[Planned Laser M Hrs][Laser Machine Planned Hours],


(t11.[LASER MACHINE]/NULLIF(t1234.[Planned Laser M Hrs],0)) as [Percentage Efficient Laser Machine],
--LASER LABOUR--

t1234.[Planned Laser L Hrs]*60 as [Planned Time Minutes Laser Labour],
t11.[LASER LABOUR]*60 as [Booked time Minutes Laser Labour],
'' as [Comments Laser Labour],
case when t0.status = 'C' then 'C' else t44.Status end[Process order step status Laser labour],
case when t44.Status='C' then t44_LB.LineID eNd [Last hour Laser Labour ],
t11.[LASER LABOUR][Booked Laser labour Hours],

t1234.[Planned Laser L Hrs][Planned Laser Labour Hours],

(t11.[LASER LABOUR]/NULLIF(t1234.[Planned Laser L Hrs],0)) as [Percentage Efficient Laser Labour],
---SAW--

t1234.[Planned SAW Hrs]*60 as [Planned Time Minutes SAW],
t11.[SAW]*60 as [Booked time Minutes SAW ],
'' as [Comments SAW],
case when t0.status = 'C' then 'C' else t66.Status end[Process order step status SAW],
case when t66.Status='C' then t66_S.LineID eNd [Last hour SAW],

t11.[SAW][Booked SAW HRs],
t1234.[Planned SAW Hrs],
(t11.[SAW]/NULLIF(t1234.[Planned SAW Hrs],0)) as [Percentage Efficient Saw],
---DEBUR--
case when t222.Status='C' then t222_D.LineID eNd [Last hour Debur],
t1234.[Planned DEBUR Hrs],
t11.[DEBUR/TIME SAVER],
---BRAKE PRES--

t1234.[Planned BRAKE Hrs]*60 as [Planned Time Minutes Brake],
t11.[BRAKE PRESS]*60 as [Booked time Minutes Brake],
'' as [Comments BRAKE Press],
case when t0.status = 'C' then 'C' else t77.Status end[Process order step status Brake],
case when t77.Status='C' then t77_B.LineID eNd [Last hour Brake],
t11.[BRAKE PRESS][Booked Brake hrs],

t1234.[Planned BRAKE Hrs],

(t11.[BRAKE PRESS]/NULLIF(t1234.[Planned BRAKE Hrs],0)) as [Percentage Efficient Brake Press ],

--POLISHING---
case when t88.Status='C' then t88_P.LineID eNd [Last hour Ploishing],
t1234.[Planned POLISHING Hrs],
t11.[POLISHING],

--MILLING--
t1234.[Planned MILLING Hrs]*60 as [Planned Time Minutes Milling],
t11.[MILLING/MACHINING/CNC]*60 as [Booked time Minutes Milling],
'' as [Comments Milling],
case when t0.status = 'C' then 'C' else t99.Status end[Process order step status Milling],
                                                     
case when t99.Status='C' then t99_M.LineID eNd [Last hour Milling],

t11.[MILLING/MACHINING/CNC][Booked MILLING Hrs],
t1234.[Planned MILLING Hrs],
(t11.[MILLING/MACHINING/CNC]/NULLIF(t1234.[Planned MILLING Hrs],0)) as [Percentage Efficient MILLING ],
  

---KITTING---
t1234.[Planned KITTING Hrs]*60 as [Planned Time Minutes Kitting],
t11.[KITTING]*60 as [Booked time Minutes Kitting],
'' as [Comments Kitting],
case when t0.status = 'C' then 'C' else t111.Status end[Process order step status Milling],
                                                     
          case when t111.Status='C' then t111_K.LineID eNd [Last hour Kitting],                                           


t11.[KITTING][Booked KItting Hrs],
t1234.[Planned KITTING Hrs],
---(t11.[KITTING]/t111.[Planned KITTING Hrs]) as [Percentage Efficient Kitting ],



(t11.[KITTING] / NULLIF(t1234.[Planned KITTING Hrs], 0)) as [Percentage Efficient Kitting],


t13.Actual_Old_Fab as [Old Fabrication Code],
t11.[FABRICATION MACHINING],


----FABRICATION CARBON STEEL--


t11.[FABRICATION CARBON STEEL]*60 as [Booked time Minutes FABRICATION CARBON STEEL],
t1234.[Planned Fabrication Carbon steel hrs]*60 as [Planned time Minutes FABRICATION CARBON STEEL],
'' as [Comments Fabrication Carbon Steel],

case when t333_FCS.Status='C' then t333.LineID eNd [Last hour Fabrication Carbon Steel],

case when t0.status = 'C' then 'C' else t333_FCS.Status end[Process Order Step status Fab Carbon Steel],

t11.[FABRICATION CARBON STEEL][Booked FABRICATION CARBON STEEL Hrs],

t1234.[Planned Fabrication Carbon steel hrs],
(t11.[FABRICATION CARBON STEEL]/NULLIF(t1234.[Planned Fabrication Carbon steel hrs],0)) as [Percentage Fabrication Carbon Steel],

-----FABRICATION DRAINAGE---

t11.[FABRICATION DRAINAGE]*60 as [Booked time Minutes FABRICATION Drainge],
t1234.[Planned Fabrication Drainage Hrs]*60 as [Planned time Minutes FABRICATION Drainge],
'' as [Comments Fabrication Drianage],
case when t444_FD.Status='C' then t444.LineID eNd [Last hour Fabrication Drainage],


case when t0.status = 'C' then 'C' else t444_FD.Status end [Process Order Step status Fab Driange],

t11.[FABRICATION DRAINAGE][Booked FABRICATION DRianage Hrs],

t1234.[Planned Fabrication Drainage Hrs],
(t11.[FABRICATION DRAINAGE]/NULLIF(t1234.[Planned Fabrication Drainage Hrs],0)) as [Percentage Fabrication Drianage],


-----FABRICATION STAINLESS FURNITURE---
t11.[FABRICATION STAINLESS FURNITURE]*60 as [Booked time Minutes FABRICATION STAINLESS FURNITURE],
t1234.[Planned Fabrication Stainless Furniture Hrs] as [Planned time Minutes FABRICATION STAINLESS FURNITURE],
'' as [Comments Fabrication STAINLESS FURNITURE],
case when t555_FSF.Status='C' then t555.LineID eNd [Last hour FABRICATION STAINLESS FURNITURE],


case when t0.status = 'C' then 'C' else t555_FSF.Status end [Process Order Step status STAINLESS FURNITURE],

t11.[FABRICATION STAINLESS FURNITURE][Booked FABRICATION STAINLESS FURNITURE Hrs],

t1234.[Planned Fabrication Stainless Furniture Hrs][Planned FABRICATION STAINLESS FURNITURE Hrs],

---(t11.[FABRICATION STAINLESS FURNITURE]/t555_FSF.[Planned Fabrication Stainless Furniture Hrs]) as [Percentage Fabrication  STAINLESS FURNITURE ],
CASE 
        WHEN t1234.[Planned Fabrication Stainless Furniture Hrs] = 0 

                                THEN NULL 
        ELSE (t11.[FABRICATION STAINLESS FURNITURE] /t1234.[Planned Fabrication Stainless Furniture Hrs]) 
    END as [Percentage Fabrication STAINLESS FURNITURE],
---FABRICATION MACHINE BUILD--
t11.[FABRICATION MACHINE BUILD]*60 as [Booked time Minutes FABRICATION MACHINE BUILD],
t1234.[Planned Fabrication Machine Build Hrs]*60 as [Planned time Minutes FABRICATION MACHINE BUILD],
'' as [Comments Fabrication MACHINE BUILD],
case when t666_FMB.Status='C' then t666.LineID eNd [Last hour Fabrication MACHINE BUILD],


case when t0.status = 'C' then 'C' else t666_FMB.Status end [Process Order Step status STAINLESS MACHINE BUILD],

t11.[FABRICATION MACHINE BUILD][Booked FABRICATION MACHINE BUILD Hrs],
t1234.[Planned Fabrication Machine Build Hrs][Planned Fabrication Machine Build Hrs],

(t11.[FABRICATION MACHINE BUILD]/NULLIF(t1234.[Planned Fabrication Machine Build Hrs],0)) as [Percentage Fabrication Machine Build ],

---NON Chargeable--
t11.[Non Chargeable Time]*60 as [Booked time Minutes NON Chargeable Time],
t1234.[NON Chargeable Time]*60 as [Planned time Minutes NON Chargeable Time],
--'' as [Comments Fabrication MACHINE BUILD],
--case when t666_FMB.Status='C' then t666.LineID eNd [Last hour Fabrication MACHINE BUILD],


--case when t0.status = 'C' then 'C' else t666_FMB.Status end [Process Order Step status STAINLESS MACHINE BUILD],

t11.[Non Chargeable Time][Booked NON Chargeable Time],
t1234.[NON Chargeable Time][Planned NON Chargeable Time],

(t11.[Non Chargeable Time]/NULLIF(t1234.[NON Chargeable Time],0)) as [Percentage NON Chargeable Time],



t11.[STAMPING AND MINOR ASSEMBLY],
t11.[ROBOTIC WELDING TRUMPF],
t11.[ROBOTIC WELDING LABOUR],
t11.[Quality Check],
t11.[DEBUR & POLISH],
t11.[DYE-PEN TESTING],
t11.[HYDROSTATIC TESTING],
t11.[FINAL ASSEMBLY],
t11.[MECHANICAL ELECTRICAL OR OTHER TESTING],
t11.[3RD PARTY FAT INSPECTION],
t11.[PACKAGING HOURS],
t11.[FINISH POLISHING],
t11.[PICKLE & PASSIVATE],
t11.[BEAD BLAST MACHINE],
t11.[BEAD BLAST LABOUR],
t11.[ELECTRO-POLISHING MACHINE],
t11.[ELECTRO-POLISHING LABOUR],
t11.[SUBCONTRACT],
t11.[CE MARKING,  EXTERNAL NDT TESTING],
t11.[Product Handover documentation and manuals],
t11.[Quality Release and customer documentation],
t11.[WRAPPING],
t11.[SITE WORK],
t11.[Non Chargeable Time],

(case   when t3.Planned_Fab >= 250 then 'A'  
                                when t3.Planned_Fab < 250 and t3.Planned_Fab >= 100 then 'B'  
                                when t3.Planned_Fab < 100 and t3.Planned_Fab >= 40 then 'C'  
                                when t3.Planned_Fab < 40 and t3.Planned_Fab >= 20 then 'D'  
                                when t3.Planned_Fab < 20  then 'E'  else 'NA' end) [Job Size Class],  
t5.DocDueDate [Due_Date],  
t7.firstname + ' ' + t7.lastName [Sales Person],   
t8.SlpName [Engineer]  
         
from IIS_EPC_PRO_ORDERH t0 

left join (select t0.CreateDate from 
FROM iis_epc_pro_ordert t0  )
t1_H1 on t1_H1.PrOrder = t0.Prorder
 LEFT JOIN (SELECT t0.PrOrder, 
        SUM(t0.Quantity) [Actual_Lab]
            FROM iis_epc_pro_ordert t0  				
                GROUP BY t0.PrOrder) 
    t1_H ON t1_H.PrOrder = t0.Prorder
inner join owor t1 on t1.U_IIS_proPrOrder = t0.PrOrder and t1.ItemCode = t0.EndProduct  

left join (                                              
                                select t1.U_IIS_proPrOrder,                                         
                                sum(t0.plannedqty * t2.avgprice) [Planned_Mat],                                             
                                sum(t0.IssuedQty* t2.avgprice) [Issued_Mat]                                      
                                from wor1 t0                                     inner join owor t1 on t1.DocEntry = t0.DocEntry                                                 
                                inner join oitm t2 on t2.ItemCode = t0.ItemCode                                                
                                where  t2.itemtype <> 'L'                                              
                                group by t1.U_IIS_proPrOrder) t2 on t2.U_IIS_proPrOrder = t0.PrOrder    

left join (
                                select t1.U_IIS_proPrOrder, sum(t0.plannedqty) [Planned_Fab]
                                from wor1 t0
                                inner join owor t1 on t1.DocEntry = t0.DocEntry
                                inner join oitm t2 on t2.ItemCode = t0.ItemCode
                                where t2.itemname like '%Fabrication%'                                                                
                                group by t1.U_IIS_proPrOrder) t3 on t3.U_IIS_proPrOrder = t0.PrOrder    

left join (                                                              
                select t1.U_IIS_proPrOrder, sum(t0.plannedqty) [Planned_Lab]                                                  
                from wor1 t0                                                     
                inner join owor t1 on t1.DocEntry = t0.DocEntry                                                                 
                inner join oitm t2 on t2.ItemCode = t0.ItemCode                                                                
                where t2.ItemType = 'L'                                                                 
                group by t1.U_IIS_proPrOrder) t9 on t9.U_IIS_proPrOrder = t0.PrOrder    
                
left join (                                                              
                select t0.PrOrder, sum(t0.Quantity) [Actual_Fab]                                                               
                from iis_epc_pro_ordert t0
                inner join oitm t1 on t1.itemcode = t0.LabourCode                                                            
                where t1.itemname like '%Fabrication%'                                                                
                group by t0.PrOrder) t4 on t4.PrOrder = t0.Prorder    
                
left join (                                                              
                select t0.PrOrder, sum(t0.Quantity) [Actual_Old_Fab]                                                     
                from iis_epc_pro_ordert t0
                inner join oitm t1 on t1.itemcode = t0.LabourCode                                                            
                where t1.itemname like 'Fabrication'                                                       
                group by t0.PrOrder) t13 on t13.PrOrder = t0.Prorder    
                

left join (                                                              
                select t0.PrOrder, sum(t0.Quantity) [Actual_Lab]                                                               
                from iis_epc_pro_ordert t0                                                          
                group by t0.PrOrder) t10 on t10.PrOrder = t0.Prorder   


left join (
                                SELECT t1.U_IIS_proPrOrder [PrOrder],
                                SUM(case when t2.itemname = 'LASER MACHINE [PLATE]' then t0.PlannedQty else 0 end)  [Planned Laser M Hrs],
                                SUM(case when t2.itemname = 'LASER LABOUR [PLATE]' then t0.PlannedQty else 0 end)  [Planned Laser L Hrs],                                      SUM(case when t2.itemname LIKE 'Laser/Saw Programming' then t0.PlannedQty else 0 end)  [Planned Laser/Saw Hrs],                                 
                                SUM(case when t2.itemname LIKE 'SAW' then t0.PlannedQty else 0 end)  [Planned SAW Hrs],                                                       
                                SUM(case when t2.itemname LIKE 'BRAKE PRESS' then t0.PlannedQty else 0 end)  [Planned BRAKE Hrs],                                      
                                SUM(case when t2.itemname LIKE 'POLISHING'then t0.PlannedQty else 0 end) [Planned POLISHING Hrs],                      
                                SUM(case when t2.itemname LIKE 'MILLING/MACHINING/CNC'then t0.PlannedQty else 0 end) [Planned MILLING Hrs],
                                SUM(case when t2.itemname LIKE 'KITTING' then t0.PlannedQty else 0 end) [Planned KITTING Hrs],
                                SUM(case when t2.itemname LIKE 'DEBUR/TIME SAVER' then t0.PlannedQty else 0 end) [Planned DEBUR Hrs],
                                SUM(case when t0.ItemCode LIKE '3000608' then t0.PlannedQty else 0 end) [Planned Fabrication Machining Hrs],
                                SUM(case when t0.ItemCode LIKE '3000609' then t0.PlannedQty else 0 end) [Planned Fabrication Carbon Steel Hrs],
                                SUM(case when t0.ItemCode LIKE '3000610' then t0.PlannedQty else 0 end) [Planned Fabrication Drainage Hrs],
                                SUM(case when t0.ItemCode LIKE '3000611' then t0.PlannedQty else 0 end) [Planned Fabrication Stainless Furniture Hrs],
                                SUM(case when t0.ItemCode LIKE '3000612' then t0.PlannedQty else 0 end) [Planned Fabrication Machine Build Hrs],
								 SUM(case when t2.Itemcode LIKE '3000623' then t0.PlannedQty else 0 end) [NON Chargeable Time]
    FROM WOR1 t0  
                inner join owor t1 on t1.DocEntry = t0.docentry
    INNER JOIN oitm t2 ON t2.itemcode = t0.itemcode
	
                where --t1.Status <> 'C'and 
				t1.CreateDate >= '01.01.2020'

   GROUP BY t1.U_IIS_proPrOrder) t1234 on t1234.PrOrder = t0.PrOrder


LEFT JOIN (  
    SELECT t0.PrOrder,MAX(t0.Status) AS Status
    FROM iis_epc_pro_orderl t0  
    INNER JOIN oitm t1 ON t1.itemcode = t0.StepItem
    WHERE t0.StepDesc LIKE 'Laser Machine'
    AND t0.LineID = (
        SELECT MAX(t0_max.LineID)
        FROM iis_epc_pro_orderl t0_max
        INNER JOIN oitm t1_max ON t1_max.itemcode = t0_max.StepItem
        WHERE t0_max.PrOrder = t0.PrOrder
        AND t0_max.StepDesc LIKE 'Laser Machine'
    )
    GROUP BY t0.PrOrder
) t33 ON t33.PrOrder = t0.Prorder

                LEFT JOIN (                                                          
    SELECT t0.PrOrder, MAX(t0.Status) AS Status
    FROM iis_epc_pro_orderl t0  
    INNER JOIN oitm t1 ON t1.itemcode = t0.StepItem
    WHERE t0.StepDesc LIKE 'Laser Labour'
    AND t0.LineID = (
        SELECT MAX(t0_max.LineID)
        FROM iis_epc_pro_orderl t0_max
        INNER JOIN oitm t1_max ON t1_max.itemcode = t0_max.StepItem
        WHERE t0_max.PrOrder = t0.PrOrder
        AND t0_max.StepDesc LIKE 'Laser Labour'
    )
    GROUP BY t0.PrOrder
)t44 ON t44.PrOrder = t0.Prorder
LEFT JOIN (                                                          
    SELECT t0.PrOrder, MAX(t0.Status) AS Status
    FROM iis_epc_pro_orderl t0  
    INNER JOIN oitm t1 ON t1.itemcode = t0.StepItem
    WHERE t0.StepDesc LIKE 'Laser/Saw Programming'
    AND t0.LineID = (
        SELECT MAX(t0_max.LineID)
        FROM iis_epc_pro_orderl t0_max
        INNER JOIN oitm t1_max ON t1_max.itemcode = t0_max.StepItem
        WHERE t0_max.PrOrder = t0.PrOrder
        AND t0_max.StepDesc LIKE 'Laser/Saw Programming'
    )
    GROUP BY t0.PrOrder
) t55 ON t55.PrOrder = t0.Prorder

LEFT JOIN (                                                          
    SELECT t0.PrOrder, MAX(t0.Status) AS Status
    FROM iis_epc_pro_orderl t0  
    INNER JOIN oitm t1 ON t1.itemcode = t0.StepItem
    WHERE t0.StepDesc LIKE 'SAW'
    AND t0.LineID = (
        SELECT MAX(t0_max.LineID)
        FROM iis_epc_pro_orderl t0_max
        INNER JOIN oitm t1_max ON t1_max.itemcode = t0_max.StepItem
        WHERE t0_max.PrOrder = t0.PrOrder
        AND t0_max.StepDesc LIKE 'SAW'
    )
    GROUP BY t0.PrOrder
) t66 ON t66.PrOrder = t0.Prorder
                
                LEFT JOIN (                                                          
    SELECT t0.PrOrder, MAX(t0.Status) AS Status
    FROM iis_epc_pro_orderl t0  
    INNER JOIN oitm t1 ON t1.itemcode = t0.StepItem
    WHERE t0.StepDesc LIKE 'BRAKE PRESS'
    AND t0.LineID = (
        SELECT MAX(t0_max.LineID)
        FROM iis_epc_pro_orderl t0_max
        INNER JOIN oitm t1_max ON t1_max.itemcode = t0_max.StepItem
        WHERE t0_max.PrOrder = t0.PrOrder
        AND t0_max.StepDesc LIKE 'BRAKE PRESS'
    )
    GROUP BY t0.PrOrder
) t77 ON t77.PrOrder = t0.Prorder
                
                LEFT JOIN (                                                          
    SELECT t0.PrOrder, MAX(t0.Status) AS Status
    FROM iis_epc_pro_orderl t0  
    INNER JOIN oitm t1 ON t1.itemcode = t0.StepItem
    WHERE t0.StepDesc LIKE 'POLISHING'
    AND t0.LineID = (
        SELECT MAX(t0_max.LineID)
        FROM iis_epc_pro_orderl t0_max
        INNER JOIN oitm t1_max ON t1_max.itemcode = t0_max.StepItem
        WHERE t0_max.PrOrder = t0.PrOrder
        AND t0_max.StepDesc LIKE 'POLISHING'
    )
    GROUP BY t0.PrOrder
) t88 ON t88.PrOrder = t0.Prorder


LEFT JOIN (                                                          
    SELECT t0.PrOrder, MAX(t0.Status) AS Status
    FROM iis_epc_pro_orderl t0  
    INNER JOIN oitm t1 ON t1.itemcode = t0.StepItem
    WHERE t0.StepDesc LIKE 'MILLING/MACHINING/CNC'
    AND t0.LineID = (
        SELECT MAX(t0_max.LineID)
        FROM iis_epc_pro_orderl t0_max
        INNER JOIN oitm t1_max ON t1_max.itemcode = t0_max.StepItem
        WHERE t0_max.PrOrder = t0.PrOrder
        AND t0_max.StepDesc LIKE 'MILLING/MACHINING/CNC'
    )
    GROUP BY t0.PrOrder
) t99 ON t99.PrOrder = t0.Prorder

                LEFT JOIN (                                                          
    SELECT t0.PrOrder, MAX(t0.Status) AS Status
    FROM iis_epc_pro_orderl t0  
    INNER JOIN oitm t1 ON t1.itemcode = t0.StepItem
    WHERE t0.StepDesc LIKE 'KITTING'
    AND t0.LineID = (
        SELECT MAX(t0_max.LineID)
        FROM iis_epc_pro_orderl t0_max
        INNER JOIN oitm t1_max ON t1_max.itemcode = t0_max.StepItem
        WHERE t0_max.PrOrder = t0.PrOrder
        AND t0_max.StepDesc LIKE 'KITTING'
    )
    GROUP BY t0.PrOrder
) t111 ON t111.PrOrder = t0.Prorder

                LEFT JOIN (                                                          
    SELECT t0.PrOrder, MAX(t0.Status) AS Status
    FROM iis_epc_pro_orderl t0  
    INNER JOIN oitm t1 ON t1.itemcode = t0.StepItem
    WHERE t0.StepDesc LIKE 'DEBUR/TIME SAVER'
    AND t0.LineID = (
        SELECT MAX(t0_max.LineID)
        FROM iis_epc_pro_orderl t0_max
        INNER JOIN oitm t1_max ON t1_max.itemcode = t0_max.StepItem
        WHERE t0_max.PrOrder = t0.PrOrder
        AND t0_max.StepDesc LIKE 'DEBUR/TIME SAVER'
    )
    GROUP BY t0.PrOrder
) t222 ON t222.PrOrder = t0.Prorder

LEFT JOIN (                                                          
    
                                SELECT t0.PrOrder, MAX(t0.Status) AS Status
    FROM iis_epc_pro_orderl t0  
    INNER JOIN oitm t1 ON t1.itemcode = t0.StepItem
    WHERE t0.StepItem LIKE '3000609'
    AND t0.LineID = (
        SELECT MAX(t0_max.LineID)
        FROM iis_epc_pro_orderl t0_max
        INNER JOIN oitm t1_max ON t1_max.itemcode = t0_max.StepItem
        WHERE t0_max.PrOrder = t0.PrOrder
        AND t0_max.stepItem like '3000609'
    )
    GROUP BY t0.PrOrder
) t333_FCS ON t333_FCS.PrOrder = t0.Prorder
                
                LEFT JOIN (                                                          
    
                                SELECT t0.PrOrder, MAX(t0.Status) AS Status
    FROM iis_epc_pro_orderl t0  
    INNER JOIN oitm t1 ON t1.itemcode = t0.StepItem
    WHERE t0.StepItem LIKE '3000610'
    AND t0.LineID = (
        SELECT MAX(t0_max.LineID)
        FROM iis_epc_pro_orderl t0_max
        INNER JOIN oitm t1_max ON t1_max.itemcode = t0_max.StepItem
        WHERE t0_max.PrOrder = t0.PrOrder
        AND t0_max.stepItem like '3000610'
    )
    GROUP BY t0.PrOrder
) t444_FD ON t444_FD.PrOrder = t0.Prorder

LEFT JOIN (                                                          
    
                                SELECT t0.PrOrder, t0.Status AS Status
    FROM iis_epc_pro_orderl t0  
    INNER JOIN oitm t1 ON t1.itemcode = t0.StepItem
    WHERE t0.StepItem LIKE '3000611'
    AND t0.LineID = (
        SELECT MAX(t0_max.LineID)
        FROM iis_epc_pro_orderl t0_max
        INNER JOIN oitm t1_max ON t1_max.itemcode = t0_max.StepItem
        WHERE t0_max.PrOrder = t0.PrOrder
        AND t0_max.stepItem like '3000611'
    )

) t555_FSF ON t555_FSF.PrOrder = t0.Prorder


LEFT JOIN (                                                          
    
                                SELECT t0.PrOrder, t0.Status AS Status
    FROM iis_epc_pro_orderl t0  
    INNER JOIN oitm t1 ON t1.itemcode = t0.StepItem
    WHERE t0.StepItem LIKE '3000612'
    AND t0.LineID = (
        SELECT MAX(t0_max.LineID)
        FROM iis_epc_pro_orderl t0_max
        INNER JOIN oitm t1_max ON t1_max.itemcode = t0_max.StepItem
        WHERE t0_max.PrOrder = t0.PrOrder
        AND t0_max.stepItem like '3000612'
    )

) t666_FMB ON t666_FMB.PrOrder = t0.Prorder



left join (              
                select t0.[PrOrder], 
[SEQ001] as 'Laser/Saw Programming',
[SEQ002] as 'LASER MACHINE',
[SEQ003] as 'LASER LABOUR',
[SEQ004] as 'SAW',
[SEQ005] as 'DEBUR/TIME SAVER',
[SEQ006] as 'BRAKE PRESS',
[SEQ007] as 'POLISHING',
[SEQ008] as 'MILLING/MACHINING/CNC',
[SEQ009] as 'KITTING',
[SEQ010A] as 'FABRICATION MACHINING',
[SEQ010B] as 'FABRICATION CARBON STEEL',
[SEQ010C] as 'FABRICATION DRAINAGE',
[SEQ010D] as 'FABRICATION STAINLESS FURNITURE',
[SEQ010E] as 'FABRICATION MACHINE BUILD',
[SEQ010F] as 'ROBOTIC WELDING TRUMPF',
[SEQ010G] as 'ROBOTIC WELDING LABOUR',
[SEQ011] as 'STAMPING AND MINOR ASSEMBLY',
[SEQ012] as 'Quality Check',
[SEQ013] as 'DEBUR & POLISH',
[SEQ014] as 'DYE-PEN TESTING',
[SEQ015] as 'HYDROSTATIC TESTING',
[SEQ016] as 'FINAL ASSEMBLY',
[SEQ017] as 'MECHANICAL ELECTRICAL OR OTHER TESTING',
[SEQ018] as '3RD PARTY FAT INSPECTION',
[SEQ019] as 'PACKAGING HOURS',
[SEQ020] as 'FINISH POLISHING',
[SEQ021] as 'PICKLE & PASSIVATE',
[SEQ022] as 'BEAD BLAST MACHINE',
[SEQ023] as 'BEAD BLAST LABOUR',
[SEQ024] as 'ELECTRO-POLISHING MACHINE',
[SEQ025] as 'ELECTRO-POLISHING LABOUR',
[SEQ026] as 'SUBCONTRACT',
[SEQ027] as 'CE MARKING,  EXTERNAL NDT TESTING',
[SEQ028] as 'Product Handover documentation and manuals',
[SEQ029] as 'Quality Release and customer documentation',
[SEQ030] as 'WRAPPING',
[SEQ031] as 'SITE WORK',
[SEQ032] as 'Non Chargeable Time'

from (
                                                SELECT t0.PrOrder,  
                                                CASE 
												WHEN max(t1.ItemName)  = 'ASSEMBLY' THEN 'SEQ016'
												ELSE t1.U_OldCode 
												END AS [Labour_Sequence],
												ISNULL(SUM(t0.Quantity), 0) AS [Actual_Lab]
												FROM iis_epc_pro_ordert t0
												INNER JOIN oitm t1 ON t1.ItemCode = t0.LabourCode
												INNER JOIN iis_epc_pro_orderh t2 ON t2.PrOrder = t0.PrOrder
												WHERE t2.CreateDate >= '2020-01-01'
												GROUP BY t0.PrOrder, t1.U_OldCode                                                )              
as t0

                PIVOT
                (
                                SUM(t0.[Actual_Lab]) 
                FOR t0.[Labour_Sequence] IN (
                [SEQ001], [SEQ002],[SEQ003], [SEQ004],
                [SEQ005], [SEQ006],[SEQ007], [SEQ008],
                [SEQ009], [SEQ010A],[SEQ010B],[SEQ010C],
                [SEQ010D],[SEQ010E],[SEQ010F],[SEQ010G],
                [SEQ011], [SEQ012],
                [SEQ013], [SEQ014],[SEQ015], [SEQ016],
                [SEQ017], [SEQ018],[SEQ019], [SEQ020],
                [SEQ021], [SEQ022],[SEQ023], [SEQ024],
                [SEQ025], [SEQ026],[SEQ027], [SEQ028],
                [SEQ029], [SEQ030],[SEQ031],[SEQ032]))
                as t0
                
                ) as t11 on t11.prorder = t0.PrOrder


                
left join(

    SELECT MAX(created) AS LineID,PrOrder
    FROM iis_epc_pro_ordert
    WHERE LabourCode = '3000004'
   
   group by prOrder
) t33_LM ON t33_LM.PrOrder = t0.PrOrder 
left join(

    SELECT MAX(created) AS LineID,PrOrder
    FROM iis_epc_pro_ordert
    WHERE LabourCode = '3000003'
   
   group by prOrder
) t44_LB ON t44_LB.PrOrder = t0.PrOrder 

left join(

    SELECT MAX(created) AS LineID,PrOrder
    FROM iis_epc_pro_ordert
    WHERE LabourCode = '3000601'
   
   group by prOrder
) t66_S ON t66_S.PrOrder = t0.PrOrder 

left join(

    SELECT MAX(created) AS LineID,PrOrder
    FROM iis_epc_pro_ordert
    WHERE LabourCode = '3000007'
   
   group by prOrder
) t77_B ON t77_b.PrOrder = t0.PrOrder 

left join(

    SELECT MAX(created) AS LineID,PrOrder
   FROM iis_epc_pro_ordert
    WHERE LabourCode = '3000002'
   
   group by prOrder
) t777 ON t777.PrOrder = t0.PrOrder 

left join(

    SELECT MAX(created) AS LineID,PrOrder
    FROM iis_epc_pro_ordert
    WHERE LabourCode = '3000005'
   
   group by prOrder
) t88_P ON t88_P.PrOrder = t0.PrOrder 

left join(

    SELECT MAX(created) AS LineID,PrOrder
    FROM iis_epc_pro_ordert
    WHERE LabourCode = '3000602'
   
   group by prOrder
) t222_D ON t222_D.PrOrder = t0.PrOrder 

left join(

  SELECT MAX(created) AS LineID,PrOrder
    FROM iis_epc_pro_ordert
    WHERE LabourCode = '30000607'
   
   group by prOrder
) t55_LSP ON t55_LSP.PrOrder = t0.PrOrder 

left join(

  SELECT MAX(created) AS LineID,PrOrder
    FROM iis_epc_pro_ordert
    WHERE LabourCode = '3000603'
   
   group by prOrder
) t111_K ON t111_K.PrOrder = t0.PrOrder 

left join(
SELECT MAX(created) AS LineID,PrOrder
    FROM iis_epc_pro_ordert
    WHERE LabourCode = '3000604'
   
   group by prOrder
) t99_M ON t99_M.PrOrder = t0.PrOrder 

--Fabrication Carbon Steel---
left join(
SELECT MAX(created) AS LineID,PrOrder
    FROM iis_epc_pro_ordert
    WHERE LabourCode = '3000609'
   
   group by prOrder
) t333 ON t333.PrOrder = t0.PrOrder 
---Fabrication Drainage---
left join(
SELECT MAX(created) AS LineID,PrOrder
    FROM iis_epc_pro_ordert
    WHERE LabourCode = '3000610'
   
   group by prOrder
) t444 ON t444.PrOrder = t0.PrOrder 
---Fabrication Stainless Furniture--
left join(
SELECT MAX(created) AS LineID,PrOrder
    FROM iis_epc_pro_ordert
    WHERE LabourCode = '3000611'
   
   group by prOrder
) t555 ON t555.PrOrder = t0.PrOrder 
---Fabrication Machine Build
left join(
SELECT MAX(created) AS LineID,PrOrder
    FROM iis_epc_pro_ordert
    WHERE LabourCode = '3000612'
   
   group by prOrder
) t666 ON t666.PrOrder = t0.PrOrder 
--Non chargeable--


left join (
select t1.PrOrder, max(t0.Created) [Last Hour Booked]
                                                from iis_epc_pro_ordert t0
                                                inner join iis_epc_pro_orderh t1 on t1.PrOrder = t0.PrOrder
                                                inner join oitm t3 on t3.ItemCode = t0.LabourCode
                                                where t0.Quantity > 0
                                                group by t1.PrOrder) t12 on t12.PrOrder = t0.PrOrder
                
left join ordr t5 on t5.docnum = t1.OriginNum  
left join oitm t6 on t6.ItemCode = t0.EndProduct  
left join ohem t7 on t7.empID = t5.OwnerCode  
left join oslp t8 on t8.SlpCode = t5.SlpCode  
LEFT JOIN oitb t17 ON t17.ItmsGrpCod = t6.ItmsGrpCod  
--where 1 = 1 and 
--                                and t5.CANCELED <> 'Y'
   --                           t5.DocDate >= '01.01.2020'
--                                and t0.Status <> 'R'


where  --t0.Status <> 'R' and 
t1.U_IIS_proPrOrder>30000
and t17.ItmsGrpNam='NON-PRODUCTIVE TIME'


";

$results="SELECT 
    t1.PrOrder,
    t1.SoNum,
    t4.ItmsGrpNam,
	t2.Itemname,
	t1.EndProduct,
    CONVERT(VARCHAR(10), t1.CreateDate, 103) AS [CreateDate],
    YEAR(t1.CreateDate) AS [Year],
    MONTH(t1.CreateDate) AS [Month],
    DATEPART(iso_week, t1.CreateDate) AS [Week],
    t2.U_Product_Group_One,
    t2.U_Product_Group_Two,
    t2.U_Product_Group_Three,
    t1.Status,
    CONVERT(VARCHAR(10), maxDateSubquery.MaxCreatedDate, 103) AS [Date of Last Entry], -- Format date as DD/MM/YYYY
    ISNULL(agg.TotalBookedHours, 0) AS [Total Hours from Subquery],
    t9.Planned_Lab,
    -- Calculate the percentage of booked hours to planned hours with 2 decimal places and a percentage sign
    CASE 
        WHEN t9.Planned_Lab = 0 THEN '0.00%'
        ELSE FORMAT((CAST(ISNULL(agg.TotalBookedHours, 0) AS DECIMAL(18, 2)) / CAST(t9.Planned_Lab AS DECIMAL(18, 2))) * 100, '0.00') + '%'
    END AS [Percentage Booked Hours]
FROM 
    iis_epc_pro_orderh t1 
INNER JOIN 
    oitm t2 ON t2.ItemCode = t1.EndProduct
INNER JOIN 
    oitb t4 ON t4.ItmsGrpCod = t2.ItmsGrpCod

INNER JOIN 
    (
        SELECT 
            t0.PrOrder,
            ISNULL(SUM(t0.Quantity), 0) AS TotalBookedHours
        FROM 
            iis_epc_pro_ordert t0

                                WHERE
                                t0.Created >= DATEADD(YEAR, -1, GETDATE()) 
        GROUP BY 
            t0.PrOrder
    ) agg ON agg.PrOrder = t1.PrOrder
INNER JOIN 
    (
        SELECT 
            t1.U_IIS_proPrOrder, 
            SUM(t0.plannedqty) AS [Planned_Lab]                                                  
        FROM 
            wor1 t0                                                     
        INNER JOIN 
            owor t1 ON t1.DocEntry = t0.DocEntry                                                                 
        INNER JOIN 
            oitm t2 ON t2.ItemCode = t0.ItemCode                                                                
        WHERE 
            t2.ItemType = 'L'                                                                 
        GROUP BY 
            t1.U_IIS_proPrOrder
    ) t9 ON t9.U_IIS_proPrOrder = t1.PrOrder
INNER JOIN 
    (
        SELECT 
            PrOrder,
            MAX(Created) AS MaxCreatedDate
        FROM 
            iis_epc_pro_ordert
        GROUP BY 
            PrOrder
    ) maxDateSubquery ON maxDateSubquery.PrOrder = t1.PrOrder
WHERE 
    t4.ItmsGrpCod='197'
	and t2.ItemName not like '%training%'
  --and t1.PrOrder=56414
GROUP BY 
    t1.PrOrder,
    t1.SoNum,
    t4.ItmsGrpNam,
    agg.TotalBookedHours,
    t9.Planned_Lab,
    t1.CreateDate,
    YEAR(t1.CreateDate),
    MONTH(t1.CreateDate),
    DATEPART(iso_week, t1.CreateDate),
    t2.U_Product_Group_One,
    t2.U_Product_Group_Two,
    t2.U_Product_Group_Three,
    t1.Status,
    CONVERT(VARCHAR(10), maxDateSubquery.MaxCreatedDate, 103),
		t2.Itemname,
	t1.EndProduct
               --t10.ItemName


	
";
$results_operator_entries="SELECT 

ISNULL(t3.SOnum,'STOCK ORDER') [Sales Order],
t0.prorder [Process Order],
CAST(t0.Quantity AS DECIMAL (12,2))[Hours],
t0.Created [Date of Entry],
DATEPART (ISO_WEEK, t0.Created) [Week no.],
datepart (ISO_WEEK, getdate()) [This week No.], 
CASE
    WHEN DATEPART(WEEKDAY,t0.CREATED) = 2 THEN 'mon'
    WHEN DATEPART(WEEKDAY,t0.CREATED) = 3 THEN 'tue'
    WHEN DATEPART(WEEKDAY,t0.CREATED) = 4 THEN 'wed'
    WHEN DATEPART(WEEKDAY,t0.CREATED) = 5 THEN 'thu'
    WHEN DATEPART(WEEKDAY,t0.CREATED) = 6 THEN 'fri'
    WHEN DATEPART(WEEKDAY,t0.CREATED) = 7 THEN 'sat'
    WHEN DATEPART(WEEKDAY,t0.CREATED) = 1 THEN 'sun'
END[Weekday],
t0.labourcode,
t2.ItemName [Labour Name],
t3.EndProduct, 
(case when t0.userid is not null then  (t1.firstname + ' ' + t1.lastname) else 'Unknown' end) as 'Operator', t0.UserId [Employee Number],
t0.RecId,
t4.ItemName,
t44.CardName,
(case when t3.endproduct = '1000000' then t0.Quantity else '0' end) [NP Time],
t5.Name,
DATEPART (YEAR, t0.Created) [Year]


FROM IIS_EPC_PRO_ORDERT t0

RIGHT JOIN ohem t1 on t0.userid = t1.empid
JOIN oitm t2 on t0.labourcode = t2.ItemCode 
JOIN IIS_EPC_PRO_ORDERH t3 on t0.prorder = t3.PrOrder


LEFT JOIN(
    SELECT t1.itemcode, t1.ItemName FROM OITM t1
) t4 ON t3.endproduct = t4.itemcode
LEFT JOIN(
    SELECT t11.CardName,t11.DocNum FROM ordr t11
) t44 ON t44.DocNum =t3.SONum

LEFT JOIN oubr t5 on t5.Code = t1.branch
INNER JOIN 
    oitb t_4 ON t_4.ItmsGrpCod = t2.ItmsGrpCod
--inner join owor t1 on t1.U_IIS_proPrOrder = t0.PrOrder and t1.ItemCode = t0.EndProduct  
WHERE t0.userid is not null and t1.U_IIS_disEmpPin <> '505' and t1.U_IIS_disEmpPin <> '514' and t0.LabourCode <> '3000004' and t0.LabourCode <> '2999999' AND t0.Created > DATEADD(WEEK,-10,DATEADD(DAY,-DATEPART(WEEKDAY,GETDATE()),GETDATE()))
and t_4.ItmsGrpCod='197' and  t2.itemname not like '%training%'
GROUP BY  t0.prorder , t3.SONum , t0.Quantity, t0.Created, t0.labourcode, t44.CardName,t2.ItemName , t3.EndProduct, (case when t0.userid is not null then  (t1.firstname + ' ' + t1.lastname) else 'Unknown' end), t0.UserId, t4.ItemName, t0.recid, t5.Name

ORDER BY [Date of Entry] DESC";
   $getResults = $conn->prepare($results);
   $getResults->execute();
   $qlty_results = $getResults->fetchAll(PDO::FETCH_BOTH);
//$getResults = $conn->prepare($results_operator_entries);
  // $getResults_operator->execute();
   //$results_operator = $getResults_operator->fetchAll(PDO::FETCH_BOTH);
   //$json_array = array();
   //var_dump($production_exceptions_results);
   echo json_encode(array($qlty_results));
}
catch(PDOException $e){
    echo $e->getMessage();
$e->getMessage();
}
