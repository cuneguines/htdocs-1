<?php
$engr="SELECT t1.CardName, TRY_CAST(TRIM(t0.Sales_order) AS INT)[Sales_Order], t0.Engineer_name, t0.Engineer_hrs
FROM ENGINEER_HRS.dbo.Engrhrs_table01 t0
LEFT JOIN ordr t1 ON TRY_CAST(TRIM(t0.Sales_order) AS INT) = t1.DocEntry
WHERE TRIM(t0.Sales_order) NOT IN ('n/a', 'N/A', '', 'CONCEPT')
      AND TRY_CAST(TRIM(t0.Sales_order) AS INT) IS NOT NULL";
