<?php 

$grn = 
"SELECT
    isnull(t0.itemcode, 'Service Item') [itemcode],
    t0.Dscription [Description], 
    cast(t0.Quantity as decimal) [Qty Receipted], 
    cast(t5.Quantity as decimal) [Qty on PO],
    CAST(t3.OnHand AS DECIMAL(12,0))[OnHand],
    t0.BaseDocNum [Purchase Order],
    t1.CardName [Supplier],
    t2.U_NAME [Reciepted_By],
    FORMAT(cast(t1.DocDate as date),'dd-MM-yyyy') [GRN_Date],
    RIGHT('0' + CONVERT(varchar(10), t1.DocTime / 100), 2) + ':' + RIGHT('0' + CONVERT(varchar(10), t1.DocTime % 100), 2) [time_of_day_receipted],  
    isnull(t3.IsCommited,0) [qty_committed], 
    isnull(t4.ItmsGrpNam, 'Non-Stock') [stock_group],
    t6.Comments [Comments]
    from PDN1 t0
        inner join opdn t1 on t1.DocEntry = t0.DocEntry
        inner join ousr t2 on t2.USERID = t1.UserSign
        left join oitm t3 on t3.ItemCode = t0.itemcode
        left join oitb t4 on t4.ItmsGrpCod = t3.ItmsGrpCod
        inner join por1 t5 on t5.ItemCode = t0.ItemCode and t5.DocEntry = t0.BaseEntry and t5.LineNum = t0.BaseLine
        inner join opor t6 on t6.docnum = t0.BaseDocNum and t6.DocEntry = t5.DocEntry

        where t1.docdate >= dateadd(d,-21,GETDATE())
        order by t1.DocDate DESC";
?>