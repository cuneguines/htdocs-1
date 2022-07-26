<?php
    $sales_per_month_2021_sql = "SELECT SUM(t1.LineTotal)[Sales], DATEPART(MONTH,t0.DocDate)[MONTH] FROM ORDR t0 LEFT JOIN RDR1 t1 ON t1.DocEntry = t0.DocEntry  WHERE DATEPART(YEAR,t0.DocDate) = DATEPART(YEAR,GETDATE())-1 GROUP BY DATEPART(MONTH,t0.DocDate)";

    $sales_per_month_2021_sql = "SELECT SUM(t1.LineTotal)[Sales], DATEPART(MONTH,t0.DocDate)[MONTH] FROM ORDR t0 LEFT JOIN RDR1 t1 ON t1.DocEntry = t0.DocEntry  WHERE DATEPART(YEAR,t0.DocDate) = DATEPART(YEAR,GETDATE())-1 GROUP BY DATEPART(MONTH,t0.DocDate)";
    $sales_per_month_2020_sql = "SELECT SUM(t1.LineTotal)[Sales], DATEPART(MONTH,t0.DocDate)[MONTH] FROM ORDR t0 LEFT JOIN RDR1 t1 ON t1.DocEntry = t0.DocEntry  WHERE DATEPART(YEAR,t0.DocDate) = DATEPART(YEAR,GETDATE())-2 GROUP BY DATEPART(MONTH,t0.DocDate)";
    $sales_per_month_2019_sql = "SELECT SUM(t1.LineTotal)[Sales], DATEPART(MONTH,t0.DocDate)[MONTH] FROM ORDR t0 LEFT JOIN RDR1 t1 ON t1.DocEntry = t0.DocEntry  WHERE DATEPART(YEAR,t0.DocDate) = DATEPART(YEAR,GETDATE())-3 GROUP BY DATEPART(MONTH,t0.DocDate)";
?>