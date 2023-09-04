<?php
$Quality_results_non_conformance_update="select t.ID,t.*,t2.*
from ms_qual_log  t

left join (
    select t1.ID,max(t1.date_updated) as Maxdate
    from  dbo.Table_2 t1
	group by t1.ID
    
) t2 on t2.ID = t.ID "
?>