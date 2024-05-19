<?php
    define("DEFAULT_DATA",0);
    define("SINGLE_NUMBER",1);
    define("SPECIAL_DATA",2);

    define("CLOSED",0);
    define("PRE_PRODUCTION_FORECAST",1);
    define("PRE_PRODUCTION_POTENTIAL",2);
    define("PRE_PRODUCTION_CONFIRMED",3);
    define("LIVE",4);
    define("TOTAL",5);
    define("IN_STOCK",6);
    define("DELIVERED",7);
    define("INVOICED",8);

    define("DEFAULT_STAGE_NAME", 0);
    define("SHORTHAND_STAGE_NAME", 1);

    define("SEQ001",  array('Laser Program',            'Laser P'));
    define("SEQ002",  array('Laser Machine',            'Laser M'));
    define("SEQ003",  array('Laser Labour',             'Laser L'));
    define("SEQ004",  array('Saw',                      'Saw'));
    define("SEQ005",  array('Deburr',                   'Deburr'));
    define("SEQ006",  array('Brake Press',              'Brake P'));
    define("SEQ007",  array('Pipe Polish',              'Pipe Pol'));
    define("SEQ008",  array('Milling',                  'Milling'));

    define("SEQ010",  array('Old Fab Code',             'Old Fab'));
    define("SEQ010A", array('Fabrication Machining',    'Fab Mach'));
    define("SEQ010B", array('Fabrication Carbon Steel', 'Fab C St'));
    define("SEQ010C", array('Fabrication Drainage',     'Fab Drain'));
    define("SEQ010D", array('Fabrication Str Furnature','Fab St F'));
    define("SEQ010E", array('Fabrication Machine Build','Fab MB'));
    define("SEQ011",  array('Stamping & Min Assembily', 'Min Ass'));
    define("SEQ013",  array('Deburr and Polishing',     'Dbr & Pol'));
	
	define("SEQ010G",  array('Rootic Welding Valk', 'Robot Weld Valk'));
    define("SEQ010H",  array('Robotic Welding Labour', 'Robot Weld Lab'));
    define("SEQ010F",  array('Robotic Welding Trumpf',  'Robot Weld Trumpf'));
	

    define("SEQ012",  array('Quality Check',            'Qual Check'));
    define("SEQ014",  array('Dye Pen Testing',          'DP Test'));
    define("SEQ015",  array('Hydrostatic Testing',      'Hydro Test'));
    define("SEQ016",  array('Final Assembily',          'Final Ass'));
    define("SEQ017",  array('Mech, Elect & Other Tests','Other Tests'));
    define("SEQ018",  array('3rd Part F.A.T.',          'F.A.T.'));

    define("SEQ020",  array('Finish Polishing',         'Fin Polish'));
    define("SEQ021",  array('Pickle and Passivate',     'Pkl & Pass'));
    define("SEQ022",  array('Bead Blast Machine',       'Bd Blst M'));
    define("SEQ023",  array('Bead Blast Labour',        'Bd Blst L'));
    define("SEQ024",  array('Electro Polish Machine',   'E Polish M'));
    define("SEQ025",  array('Electro Polish Labour',    'E Polish L'));
    define("SEQ026",  array('Subcontract',              'Subcon'));

    define("SEQ027",  array('CE Mark & NDT Test',       'CE & NDT'));
    define("SEQ028",  array('Handover Doc & Man',       'Handover'));
    define("SEQ029",  array('Cus Quality Doccuments',   'Qual Docs'));
    
    define("SEQ009",  array('Kitting',                  'Kitting'));
    define("SEQ019",  array('Packaging',                'Packaging'));
    define("SEQ030",  array('Wrapping',                 'Wrapping'));
    define("SEQ031",  array('Site Work',                'Site Work'));
    define("SEQ032",  array('NonChargeable Time',                'NonChargeable Time'));
    define("SEQ0045",  array('LASER LABOUR [TUBE]',                'LASER LABOUR [TUBE]'));
    define("SEQ0048",  array('LASER Machine [TUBE]',                'LASER Machine [TUBE]'));
?>

<?php
    // PRODUCTION GROUP CODES
    $group_steps_template = array(
        1 => array(
        "name" => "material_prep",
        "stringname" => "Matrial Prep",
        "steps" => array(
            1 => "SEQ001",
            2 => "SEQ002",
            3 => "SEQ003",
            4 => "SEQ004",
            5 => "SEQ005",
            6 => "SEQ006",
            7 => "SEQ007",
            8 => "SEQ008"
        )),
        2 => array(
        "name" => "fabrication_1",
        "stringname" => "Fabrication 1",
        "steps" => array(
            1 => "SEQ010A",
            2 => "SEQ010B",
            3 => "SEQ010C",
            4 => "SEQ010D",
            5 => "SEQ010E",
            6 => "SEQ010F",
            7 => "SEQ010G",
            8 => "SEQ010H"
            
           
           
        )),
        3 => array(
        "name" => "fabrication_2",
        "stringname" => "Fabrication 2",
        "steps" => array(
            1 => "SEQ012",
            2 => "SEQ014",
            3 => "SEQ015",
            4 => "SEQ016",
            5 => "SEQ017",
            6 => "SEQ018",
            7 => "SEQ011",
            8 => "SEQ013" 
        )),
        4 => array(
        "name" => "finishing",
        "stringname" => "Finishing",
        "steps" => array(
            1 => "SEQ020",
            2 => "SEQ021",
            3 => "SEQ022",
            4 => "SEQ023",
            5 => "SEQ024",
            6 => "SEQ025",
            7 => "SEQ026",
            8 => "" 
        )),
        5 => array(
        "name" => "docs_and_deliverables",
        "stringname" => "Docs & Delivs", 
        "steps" => array(
            1 => "SEQ027",
            2 => "SEQ028",
            3 => "SEQ029",
            4 => "",
            5 => "",
            6 => "",
            7 => "",
            8 => "" 
        )),
        6 => array(
        "name" => "stores",
        "stringname" => "Stores",
        "steps" => array(
            1 => "SEQ009",
            2 => "SEQ019",
            3 => "SEQ030",
            4 => "SEQ031",
            5 => "SEQ032",
            6 => "SEQ0045",
            7 => "SEQ0048",
            8 => "" 
        ))
    );
?>