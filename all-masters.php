<?php
  include("./include/html_codes.php");
  include('./include/master_pagination.php');
  $event_id_res=$common->get_eventid(trim($_GET['eid']));
  $event_id = $common->check_event_id($event_id_res);
  admin_way_top();
  admin_top_bar($event_id);
  admin_left_menu($event_id);
  
  $all_master_types_array = $common->fetch_all_master_types_by_eventid($event_id);   

    $current_url = $_SERVER['REQUEST_URI'];
    if((strpos($current_url, 'typepage') == false) && (strpos($current_url,'page') == false) && (strpos($current_url,'sortpage') == false))
     {
       $_SESSION['select_all_flag_master'] = 0;
       $_SESSION['selected_ids_master'] = '';
     }

       $event_sql = mysqli_query($connect,"SELECT * FROM all_events WHERE id=".$event_id);
       $event_row = mysqli_fetch_array($event_sql);
       $event_url_structure = $event_row['event_name'];
        if( strlen($event_url_structure ) > 30 ) 
        {
          $event_url_structure = substr($event_row['event_name'], 0, 30 ) . '...';
        }
        //$sponsors_array = $common->fetch_all_master_for_popup($event_id);

      $is_upload = 0;
      $up = mysqli_real_escape_string($connect, $_GET['up']);
    if(!empty($up)) {
      $is_upload = base64_decode($up);
    }else{
      $is_upload = 0;
    }

     $total_contact_flag = $common->total_contact_checker();

     $selectAll_flag=array($_SESSION['select_all_flag_master']);
    $selected_ids=$_SESSION['selected_ids_master'];
    $selected_ids_arr=explode(',', $_SESSION['selected_ids_master']);

    if(!empty($selected_ids)) {
      $is_exists=1;
    }
?>
<link href="css/custom_aby.css" rel="stylesheet" type="text/css">
<link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
<style type="text/css">
  th {
  position: relative;
}
th form {
  position: absolute;right: 0px;
  top: 50%;
  transform: translate(0px, -50%);
}
  #information_modal .modal-header {
    background: #222;
    color: #FFF;
}
.multiselect-selected-text {
    max-width: 100px;
}
 .searchInput:before {
    display: none;
  }
  .custom-tooltip {
  position: relative;
  display:  table;
  width: 100%;
  cursor: pointer;
}

.custom-tooltip:hover::after {
  opacity: 1;
  visibility: visible;
}

.custom-tooltip:after {
    content: attr(data-title);
    position: absolute;
    top: -100%;
    left: 0;
    /* min-width: 200px; */
    word-break: break-all;
    /* max-width: 400px; */
    background: #000;
    color: #fff;
    border-radius: 5px;
    padding: 3px;
    opacity: 0;
    visibility: hidden;
    transition: all .2s ease-in-out;
    /* width: 100%; */
    text-align: center;
    font-size: 10px;
    left: 10px;
    right: 10px;
}
.a-gray{color:#343E47}
.multiselect-selected-text {
    max-width: 90px;
  }
.a-gray{color:#343E47}
#information_modal .modal-header {
  background: #222;
  color: #FFF;
}

.modal .err_cls .multiselect.dropdown-toggle.btn.btn-default{
border: 1px solid #cc0033 !important;
    outline: none;

}
 .btn-group .caret {
  top: 2px;
 }
 .modalbanner {
  background: ;
    background: -moz-linear-gradient(top, #007DB7 0%, #002C40 100%);
    background: -webkit-gradient(left top, left bottom, color-stop(0%, #007DB7), color-stop(100%, #002C40));
    background: -webkit-linear-gradient(top, #007DB7 0%, #002C40 100%);
    background: -o-linear-gradient(top, #007DB7 0%, #002C40 100%);
 }

.progress-group {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-flow: row wrap;
    flex-flow: row wrap;
    margin-bottom: 1rem;
    width:100%;
}
.progress-group-header {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-preferred-size: 100%;
    flex-basis: 100%;
    -ms-flex-align: end;
    align-items: flex-end;
    margin-bottom: .25rem;
}
.progress-group-header+.progress-group-bars {
    -ms-flex-preferred-size: 100%;
    flex-basis: 100%;
}
.progress-xs {
    height: 2px;
}
.progress {
    display: -ms-flexbox;
    display: flex;
    height: 1rem;
    overflow: hidden;
    font-size: .65625rem;
    background-color: #f0f3f5;
    border-radius: .25rem;height: 2px!important;
    margin: 0;
}
.progress-bar {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    -ms-flex-pack: center;
    justify-content: center;
    color: #fff;
    text-align: center;
    white-space: nowrap;
    background-color: #20a8d8;
    transition: width .6s ease;
    z-index: 99;
    position: absolute;
    margin-top: -1px;    height: 2px;
    position: relative;
}

.bg-more-70 {
    background-color: #0182a2!important;
}
.bg-bt-30-50 {
    background-color: #d6d717!important;
}
.bg-below-30 {
    background-color: #a32857!important;
}
.cl-blue{color:  #0182a2; font-size: 12px;}
.cl-yellow{color:  #d6d717; font-size: 12px;}
.cl-red{color:  #a32857; font-size: 12px;}
.filterText{    bottom: -25px; right: 0;}
.searchInput input{margin-right: 0; }
.filteSearch {
    margin-right: 0;
    margin-left: 0; 
    top: 9px; margin-bottom: 35px;
    }

    .download {
    background: #93a0a71c;
    height: 35px;
    float: right;
    width: 35px;
    text-align: center;
    border-radius: 30px;
    position: relative;
    top: -7px;
    left: 5px;
    padding-top: 5px;
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.04);
  }
  .iconsBoxSec {
    width: 222px !important;
}
#create_speaker_modal .modal-dialog {
  width: 350px;
}
#create_speaker_modal .modal-body {
  padding-top: 50px;
  padding-bottom: 50px;
}
.orDivider {
    font-size: 14px;
    height: 32px;
    width: 63px;
    text-align: center;
    line-height: 32px;
    position: relative;
    border: 1px solid #b5b5b5;
    border-radius: 4px;
    background: #fff;
    margin: 20px auto 25px;
}
.orDivider:before {
 position: absolute;
    content: '';
    height: 1px;
    width: 110px;
    background: #b5b5b5;
    left: -110px;
    top: 15px;
    z-index: 0;

}

.orDivider:after {
 position: absolute;
    content: '';
    height: 1px;
    width: 110px;
    background: #b5b5b5;
    right: -110px;
    top: 15px;
    z-index: 0;

}

@media (min-width: 768px){
#speakerfromDb .modal-dialog {
    width: 70%;
    margin: 30px auto;
}
}

  #speakerfromDb .modal-title{    background: #007db7;    color: #fff;    text-align: left;    padding: 15px;}
  #speakerfromDb .modal-header{padding: 0; border:none;}
  #speakerfromDb  .modal-header .close {
    margin-top: 8px;
    margin-right: 5px;
}
.prev-color {
    color: #969696;
    font-size: 10px;
}
.prev-color img {
    height: 17px;
}
.sortName {
  background: transparent;
  border: 0px;
  float: right;
    width: 30px;
    background: url(images/sort_both.png) center center no-repeat;
        height: 17px;
}
.pagination {
  margin: 0px;
}
.mstTable th form {
  float: right;
}
.paginate_button, .pagination a {
  padding: 0px 10px;
  color: #222 !important;
}
.paginate_button.current {
  font-weight: 600;
  color: #0283A3 !important;
}
.searchInput:before {
  display: none;
}
.filterText {
      right: 0px;
}
.basicsearch {
  position: relative;
}
.basicsearch input {
      border: 1px solid #dcdcdc;
    height: 35px;
        font-size: 16px !important;
    padding-left: 32px;
}
.basicsearch button {
  position: absolute;
  background: transparent;
  border: 0px;
  left: 3px;
  top: 6px;
  outline: none !important;

}

#limit_speaker_modal .modal-dialog {
  width: 350px;
}
#limit_speaker_modal .modal-body {
  padding-top: 50px;
  padding-bottom: 50px;
}
  .no-result-div{
        top: 0;
        text-align: center;
        border: 0;
        width: auto;
        font-size: 14px;
        margin: auto;
        margin-right: 50px;
        margin-left: 50px;
      }
.master_select{
		  width: auto;
		float: right;
		margin-right: 15px;
		margin-left: 15px;
	  }
	  .master_apporved{
		  float: right;
	  }
@media only screen and (min-width: 1200px){	  
	div#delete_btn {
		float: left;
	}
}	
@media only screen and (min-width: 768px) and (max-width: 991px){
	.master_select{
		margin-left: 10px;
		margin-right: 10px;
	}
}	  	  
</style>
<div class="lds-css ng-scope" style="display: none;" id="loader_div"><div style="width:100%;height:100%" class="lds-double-ring"><div></div><div></div><div><div></div></div><div><div></div></div></div></div>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper innerpageSec " style="margin-top:0 !important;">
   <!-- Content Header (Page header) -->
   <section class="content-header pad-5">
      
      <ol class="breadcrumb new-breadcrumb">
         <!-- <li><a href="dashboard.php?eid=<?php echo base64_encode($event_id).':'. base64_encode(rand(100,999)); ?>"><i class="fa fa-dashboard"></i> Home</a></li> -->
          <?php breadcrumb();  ?>
         <li class="active"><?php echo $event_url_structure; ?></li>
         <li class="active">Masters List</li>
      </ol>
      <div class="clearfix"></div>
   </section>
   <!-- Main content -->
   <section class="content pad-5">
  
      <!-- Small boxes (Stat box) -->
      <div class="row">
         <div class="col-lg-12">
      <div class="delete-success" style="text-align: center;color: green;font-size: 18px;padding: 19px;display:none">A master details has been deleted successfully!</div>
      <div class="created-success" style="text-align: center;color: green;font-size: 18px;padding: 19px;display:none">A new master details has been created successfully!</div>
      <div class="updated-success" style="text-align: center;color: green;font-size: 18px;padding: 19px;display:none">A master details has been updated successfully!</div>
      <div class="upload_success" style="text-align: center;color: green;font-size: 18px;padding: 19px;display:none">Masters details has been uploaded successfully!</div>
      <div class="upload_error" style="text-align: center;color: green;font-size: 18px;padding: 19px;display:none"><?php echo $count; ?> master details has been uploaded successfully and <?php echo $count+1; ?> row has some extra columns so please upload it again!</div>
       <div class="revert_success" style="text-align: center;color: green;font-size: 18px;padding: 19px;display:none">Masters details has been reverted successfully!</div>

        <div class="upload_limit_exceed" style="text-align: center;color: red;font-size: 18px;padding: 19px;display:none">Master upload failed! Contact limit exceeds for this subscription plan.</div>
            <div class="request-success" style="text-align: center;color: green;font-size: 18px;padding: 19px;display:none">Information request has been sent successfully!</div>


      <style type="text/css">
                                /****** CODE ******/
                                
                                .file-upload{display:block;text-align:center;font-size: 12px;width: 300px; float:left;margin-bottom: 5px;margin-right: 10px;}
                                .file-upload .file-select{display:block;border: 2px solid #dce4ec;color: #34495e;cursor:pointer;height:36px;text-align:left;background:#FFFFFF;overflow:hidden;position:relative;}
                                .file-upload .file-select .file-select-button{background:#dce4ec;padding:0 10px;display:inline-block;height:36px;line-height:32px;}
                                .file-upload .file-select .file-select-name{line-height: 32px;
                                    display: inline-block;
                                    padding: 0 10px;
                                    position: absolute;
                                    width: auto;
                                    right: 0;
                                    left: 80px;}
                                .file-upload .file-select:hover{border-color:#34495e;transition:all .2s ease-in-out;-moz-transition:all .2s ease-in-out;-webkit-transition:all .2s ease-in-out;-o-transition:all .2s ease-in-out;}
                                .file-upload .file-select:hover .file-select-button{background:#34495e;color:#FFFFFF;transition:all .2s ease-in-out;-moz-transition:all .2s ease-in-out;-webkit-transition:all .2s ease-in-out;-o-transition:all .2s ease-in-out;}
                                .file-upload.active .file-select{border-color:#3fa46a;transition:all .2s ease-in-out;-moz-transition:all .2s ease-in-out;-webkit-transition:all .2s ease-in-out;-o-transition:all .2s ease-in-out;}
                                .file-upload.active .file-select .file-select-button{background:#3fa46a;color:#FFFFFF;transition:all .2s ease-in-out;-moz-transition:all .2s ease-in-out;-webkit-transition:all .2s ease-in-out;-o-transition:all .2s ease-in-out;}
                                .file-upload .file-select input[type=file]{z-index:100;cursor:pointer;position:absolute;height:100%;width:100%;top:0;left:0;opacity:0;filter:alpha(opacity=0);}
                                .file-upload .file-select.file-select-disabled{opacity:0.65;}
                                .file-upload .file-select.file-select-disabled:hover{cursor:default;display:block;border: 2px solid #dce4ec;color: #34495e;cursor:pointer;height:40px;line-height:40px;margin-top:5px;text-align:left;background:#FFFFFF;overflow:hidden;position:relative;}
                                .file-upload .file-select.file-select-disabled:hover .file-select-button{background:#dce4ec;color:#666666;padding:0 10px;display:inline-block;height:40px;line-height:40px;}
                                .file-upload .file-select.file-select-disabled:hover .file-select-name{line-height:40px;display:inline-block;padding:0 10px;}
                              </style>                              
                              

      <section class="box box-primary" style="padding: 15px;display:none" id="import_section">
      <div class="card-box">
          <form method="post" action="include/form_submits.php" enctype="multipart/form-data">

            <div class="file-upload">
              <input type="hidden" name="action" value="masters_upload" />
              <!-- <input type="hidden" name="action" value="sample_upload" /> -->
            <input type="hidden" name="evt_id" value="<?php echo $event_id; ?>" id="evt_id" >
              <div class="file-select">
                <div class="file-select-button" id="fileName">Choose File</div>
                <div class="file-select-name" id="noFile">No file chosen...</div> 

                <input type="file"  name="file" id="masters_upload" required="" accept=".csv" style="display:inline" onChange= "Validate('masters_upload')">
                <!-- <input type="file" accept="image/*" name="fileToUpload" id="chooseFile" required="true"> -->
              </div>
          </div>


            
            
            <button type="submit" id="master_upload_btn" disabled="true" name="import" onclick="master_pre_upload_loader();" class="btn btn-primary btn-sm" style="display:inline;padding: 8px 15px;">Upload</button>
          </form>
        </div>  
      </section>
      
            <section class="box box-primary">
               <div class="card-box table-responsive" style="padding: 17px; padding-top:0;min-height: 82vh;">
                <h2 class="pull-left mainHd" style="margin-top: 0px;"><?php echo $event_url_structure; ?> : Masters List</h2>
                <?php 
                if($total_contact_flag!=0) 
                {
                  echo '<a class="btn btn-success pull-right createSpkrbtn" href="#" data-toggle="modal" data-target="#limit_speaker_modal">Create New</a>';
                }else
                {
                  echo '<a class="btn btn-success pull-right createSpkrbtn" href="#" data-toggle="modal" data-target="#create_speaker_modal">Create New</a>';
                }
                ?>
    
      &nbsp;
  <?php if(!isset($_GET['masters-approved'])){ ?>
    <a class="btn btn-success importSpkrbtn" style="float:right;margin-right:5px" href="" onclick="$('#import_section').toggle();return false;">Import Masters</a>&nbsp;
    <a class="btn btn-success exportSpkrbtn" style="float:right;margin-right:5px" href="masters-export.php?event_id=<?php echo $event_id;?>" onclick="hideloader();">Export Masters</a>
    <!-- <a class="btn btn-success" style="float:right;margin-right:5px;display: none;" id="revert">Revert</a> -->
    <p id="revert"></p>
    <!-- <a class="btn btn-success" style="float:right;margin-right:5px" href="excel/masters-sample.csv">Download Sample Excel</a> -->&nbsp;
  <?php }else{ echo "<br>"; } ?>
<div class="clearfix"></div>
  <br>
  <form class="searchInput" style="width: 200px;">
              <div class="form-group">
                <p class="blue-n-color filterText"><img src="images/filter.svg" width="10"> Advanced Search</p>
              </div>
            </form>
            <div class="clearfix"></div>
            
       <div class="filteSearch" style="display: none;">

              <div class="container-fluid">
                
              <div class="row">
               <a onclick="refresh_page();"><img src="images/crossBlack.svg" class="searchImge pull-right" ></a>
                <div class="col-md-12">
                  <p class="blue-n-color">Advanced Search</p>
                </div>
                <div class="clearfix"></div>
                <div id="advnc">
                  <div class="col-md-4  form-group">
                     <input type="text" class="form-control" id="master_name" placeholder="Master Name" >
                  </div>
                  <div class="col-md-4  form-group">
                     <input type="email" class="form-control" id="master_email" placeholder="Master Email Address" >
                  </div>
                  
                  <div class="col-md-4  form-group">
                     <input type="text" class="form-control" id="contact" placeholder="Contact" >
                  </div>
          
                  <div class="col-md-4  form-group">
                     <input type="text" class="form-control" id="company_name" placeholder="Company Name" >
                  </div>
                 
                  <div class="col-md-4  form-group">
                    <select class="form-control" id="master_type" required="" name="master_type">
                    <option value="">Select Type</option>
                           <?php
                           $all_masters_array = $common->fetch_all_master_types_asc($event_id); 
                           foreach($all_masters_array as $all_masters){
                              $master_type_name = $all_masters['master_type_name'];
                              echo "<option value='".$all_masters['id']."' >".$master_type_name."</option>";
                           }
                        ?>
                           </select>
                  </div>
                  

              </div>
               </div>
              <div class="row">
                <div class="col-md-6">
                
                </div>
                <div class="col-md-6">
                  <a onclick="Advanced_master_search();" class="btn btn-success pull-right" style="margin-right: 0px;min-width: 100px;margin-bottom: 20px;">Search</a>
                </div>
                
              </div>
              </div>

            </div>
            <div class="clearfix"></div>
            <div class="form-group pull-right basicsearch">
              <input type="search" name="" placeholder="Search" id="searchbtnval">
              <button class="searchbtn" id="normal_search"><img src="images/search.png"></button>
            </div>
<div class="row">
                <div class="col-md-8">
					<div id="delete_btn" style="display:none;">
						<a style="cursor:pointer;border-right:0px;background: #a32857 !important;border-color: #a32857 !important;" class="btn btn-success"  onClick='confirmDeleteAll()'>
						<i class="fa fa-trash" aria-hidden="true"></i> Delete Selected</a>
						 <select class="master_select form-control">
              <option value="0"> Change Status </option>
              <?php 
                            $master_approval_staus_array = $common->fetch_master_approval_new_status(); 
                            foreach($master_approval_staus_array as $all_status){
                                 echo "<option value='".$all_status['value']."'>".$all_status['display_name']."</option>";
                                 }
                  ?>
            </select>
					</div>
                </div>
                
                
              </div>
<div class="clearfix"></div>
               <table id=" " class="table  table-bordered table-responsive mstTable" style="width:100%">
                     <thead>
                        <tr>
                            <th id="select_div"><input type="checkbox" class="example" onClick="check_uncheck_checkbox(this.checked);" name="select_all" id="example-select-all" <?php if (in_array(1, $selectAll_flag)){ echo "checked";} ?>></th>
                           <th style="min-width: 100px;">Name<form method="post" action='all-masters.php?eid=<?php echo base64_encode($event_id).':'.base64_encode(rand(100,999)); ?>&sort_mname=Name'><button type='submit' class="sortName" name='sort_mname' value='Name'></button></form></th>
                           <!-- <th>Last Name</th> -->
                           <th style="min-width: 100px;">Email Address<form method="post" action='all-masters.php?eid=<?php echo base64_encode($event_id).':'.base64_encode(rand(100,999)); ?>&sort_mname=Email Address'><button type='submit' class="sortName" name='sort_mname' value='Email Address'></button></form></th>
                           <th style="min-width: 80px;">Contact<form method="post" action='all-masters.php?eid=<?php echo base64_encode($event_id).':'.base64_encode(rand(100,999)); ?>&sort_mname=Contact'><button type='submit' class="sortName" name='sort_mname' value='Contact'></button></form></th>
                           <th style="min-width: 100px;">Title<form method="post" action='all-masters.php?eid=<?php echo base64_encode($event_id).':'.base64_encode(rand(100,999)); ?>&sort_mname=Title'><button type='submit' class="sortName" name='sort_mname' value='Title'></button></form></th>
                           <th style="min-width: 80px;">Company<form method="post" action='all-masters.php?eid=<?php echo base64_encode($event_id).':'.base64_encode(rand(100,999)); ?>&sort_mname=Company'><button type='submit' class="sortName" name='sort_mname' value='Company'></button></form></th>
                           <th style="min-width: 80px;">Email Sent</th>
                           <th width="100px" style="width: 100px!important; max-width: 100px !important">Type<form method="post" action='all-masters.php?eid=<?php echo base64_encode($event_id).':'.base64_encode(rand(100,999)); ?>&sort_mname=Type'><button type='submit' name='sort_mname' class="sortName" value='Type'></button></form></th>                           
                           <th ><div style="min-width: 139px;">Manage</div></th>
                        </tr>
                     </thead>
                     <tbody id="master_body"> 
                        <?php 
                          $adjacents = "3";
                          $limit = "10";
                          $page = isset($_GET['page'])?$_GET['page']:0;
                          $targetpage = "all-masters.php?eid=".base64_encode($event_id).':'.base64_encode(rand(100,999));
                          $pagination = pagination_2($adjacents,$limit, $page, $targetpage,$event_id);       
                          $pagination_array = explode("~",$pagination);
                          $sql = $pagination_array[0];
                 
                           $all_masters_array = $common->fetch_all_masters($pagination_array[2],$limit,$event_id); 

                           if(isset($_GET['event_dashboard'])){
                             $all_masters_array = $common->fetch_all_masters_event_dashboard(); 
                           }else if(isset($_GET['tid'])){
                              $adjacents2 = "3";
                              $limit2 = "10";
                              $page2 = isset($_GET['typepage'])?$_GET['typepage']:0;
                              $targetpage2 = "all-masters.php?eid=".base64_encode($event_id).':'.base64_encode(rand(100,999)).'&tid='.$_GET['tid'];

                              $pagination2 = pagination_for_type($adjacents2,$limit2, $page2, $targetpage2,$event_id,trim($_GET['tid']));  
                              $pagination_array = explode("~",$pagination2);
                              $sql2 = $pagination_array[0];

                             $all_masters_array = $common->fetch_all_masters_with_condition(trim($_GET['tid']),$pagination_array[2],$limit2,$event_id); 
                           }else if(isset($_GET['masters_with_no_company'])){
                            $page2 = isset($_GET['typepage'])?$_GET['typepage']:0;
                            $targetpage2 = "all-masters.php?eid=".base64_encode($event_id).':'.base64_encode(rand(100,999)).'&masters_with_no_company';
                            $pagination2 = pagination_for_conditions("","","masters_with_no_company",$adjacents,$limit, $page2, $targetpage2,$event_id);
                            $pagination_array = explode("~",$pagination2);
                            $sql2 = $pagination_array[0];
                           $all_masters_array = $common->fetch_all_masters_with_conditions("","","masters_with_no_company",$pagination_array[2],$limit,$event_id); 
                         }else if(isset($_GET['masters_with_no_linked_handles'])){
                            $page2 = isset($_GET['typepage'])?$_GET['typepage']:0;
                            $targetpage2 = "all-masters.php?eid=".base64_encode($event_id).':'.base64_encode(rand(100,999)).'&masters_with_no_linked_handles';
                            $pagination2 = pagination_for_conditions("","","masters_with_no_linked_handles",$adjacents,$limit, $page2, $targetpage2,$event_id);
                            $pagination_array = explode("~",$pagination2);
                            $sql2 = $pagination_array[0];
                           $all_masters_array = $common->fetch_all_masters_with_conditions("","","masters_with_no_linked_handles",$pagination_array[2],$limit,$event_id); 
                           }else if(isset($_GET['masters_with_no_mobile'])){
                             $page2 = isset($_GET['typepage'])?$_GET['typepage']:0;
                            $targetpage2 = "all-masters.php?eid=".base64_encode($event_id).':'.base64_encode(rand(100,999)).'&masters_with_no_mobile';
                            $pagination2 = pagination_for_conditions("","","masters_with_no_mobile",$adjacents,$limit, $page2, $targetpage2,$event_id);
                            $pagination_array = explode("~",$pagination2);
                            $sql2 = $pagination_array[0];
                           $all_masters_array = $common->fetch_all_masters_with_conditions("","","masters_with_no_mobile",$pagination_array[2],$limit,$event_id); 
                         }else  if(isset($_GET['type'])){
                          $all_masters_array = $common->fetch_all_masters_by_opportunity_type($_GET['type'],$pagination_array[2],$limit,$event_id);
                         }  


                         if(isset($_GET['sort_mname'])){
                           if($_GET['sortpage']==NULL)
                            {
                              $order=0;
                            }else
                            {
                              $order=1;
                            }
                           $page2 = isset($_GET['sortpage'])?$_GET['sortpage']:0;
                            $targetpage2 = "all-masters.php?eid=".base64_encode($event_id).':'.base64_encode(rand(100,999)).'&sort_mname='.$_GET['sort_mname'];

                            $pagination2 = pagination_for_sorting($adjacents,$limit, $page2, $targetpage2,$event_id);  
                            $pagination_array = explode("~",$pagination2);
                            $sql2 = $pagination_array[0];

                           $all_masters_array = sort_table($page2,$limit,$_GET['sort_mname'],$event_id,$order);
                          //$all_masters_array = sort_table($pagination_array[2],$limit,$_GET['sort_mname'],$event_id);
                        }  
               
               
                //prepare status dropdown
                 $all_status_array = $common->fetch_all_status_asc('master',$event_id); 

                  $status_dropdown = "<select  name='status_update' id='status_update' class='form-control status_update'><option value=''>Select a status </option>"; 
                  foreach($all_status_array as $all_status){

                    $sel = "";
                   if ($all_status['id'] == $status_name) $sel = " selected ";
                   $status_dropdown = $status_dropdown .
                                        "<option data-id=".$all_masters['id']."  value=".$all_status['id']." ".$sel ."> ".$all_status['status_name']." </option> ";
                  } // end of foreach
                  $status_dropdown = $status_dropdown. "</select>";
         
                           
                           foreach($all_masters_array as $all_masters){
                 $status_name = $all_masters['status_name'];
                 if(!$status_name){
                   $status_name = " - ";
                 }
                 $company = $all_masters['company'];
                 if(!$company){
                   $company = " - ";
                 }
                 $template_name = $all_masters['template_name'];
                 if(empty($template_name)){
                   $template_name = " - ";
                 }else{
                   $template_name = "<a href='#' onclick='masterTemplateModal(".$all_masters['log_id'].")'>".$template_name."</a>"; 
                 }


                  $master_type = explode(",",$all_masters['master_type']);

               /*<td data-search='".$all_masters['master_name']."' data-order='".$all_masters['master_name']."'>              
                    <input type='text' class='form-control required master_last_name' placeholder='Last Name'  name='master_last_name' id='".$all_masters['id']."' title='Contact Person' value='".$all_masters['master_lastname']."' />
                    <div style='color:green;display:none;text-align:center;margin:10px' class='master_last_name_success success_msg' id='master_last_name_succcess_".$all_masters['id']."'><font>Updated Successfully!</font>
                  </td> */

                echo "<tr>";
                 if (in_array($all_masters['id'],$selected_ids_arr))
                    {
                      echo "<td><input type='checkbox' name='row_id' id='row_id' class='spkid'  value=".$all_masters['id']." checked></td>";
                    }else
                    {
                      echo "<td><input type='checkbox' name='row_id' id='row_id'  class='spkid' value=".$all_masters['id']."></td>";
                    }
                  echo "<td data-search='".$all_masters['master_name']."' data-order='".$all_masters['master_name']."'>              
                    <input type='text' class='form-control required master_first_name' placeholder='Name'  name='master_name' id='".$all_masters['id']."' title='Master Name' value='".$all_masters['master_name']."' />
                    <div style='color:green;display:none;text-align:center;margin:10px' class='master_first_name_success success_msg' id='master_first_name_succcess_".$all_masters['id']."'><font>Updated Successfully!</font>
                  </td>


                
                                
                  
                  <td style='word-break: break-all;' data-search='".$all_masters['email_id']."' data-order='".$all_masters['email_id']."'>
                  <input type='text' class='form-control required email_id' placeholder='Email Address'  name='email_id' id='".$all_masters['id']."' title='Email Address' value='".$all_masters['email_id']."' />
                    <div style='color:green;display:none;text-align:center;margin:10px' class='email_id_success success_msg' id='email_id_succcess_".$all_masters['id']."'><font >Updated Successfully!</font></div>
                    <div style='color:red;display:none;text-align:center;margin:10px' class='email_id_error' id='email_id_error_".$all_masters['id']."'><font >Valid email address is required!</font></div>
                    <div style='color:red;display:none;text-align:center;margin:10px' class='email_id_dup' id='email_id_dup_".$all_masters['id']."'><font >Failed! Email address already exist.</font></div>


                  </td>

                   <td style='word-break: break-all;' data-search='".$all_masters['phone']."' data-order='".$all_masters['phone']."'>
                    <input type='text' class='form-control required phone' placeholder='Contact Number'  name='phone' id='".$all_masters['id']."' title='Example:123-456-7890' value='".$all_masters['phone']."' />
                    <div style='color:green;display:none;text-align:center;margin:10px' class='phone_success success_msg' id='phone_succcess_".$all_masters['id']."'><font >Updated Successfully!</font></div>
                    <div style='color:red;display:none;text-align:center;margin:10px' class='phone_error' id='phone_error_".$all_masters['id']."'><font >Valid contact number is required (Example:123-456-7890)</font></div>
                  </td>


                    <td style='word-break: break-all;' data-search='".$all_masters['job_title']."' data-order='".$all_masters['job_title']."'>
                  <input type='text' class='form-control required job_title' placeholder='Job Title'  name='job_title' id='".$all_masters['id']."' title='Job Title' value='".$all_masters['job_title']."' />
                    <div style='color:green;display:none;text-align:center;margin:10px' class='job_title_success success_msg' id='job_title_succcess_".$all_masters['id']."'><font >Updated Successfully!</font></div>  
                  </td>
                  
                     <td style='word-break: break-all;' data-search='".$all_masters['company']."' data-order='".$all_masters['company']."'>

                  <input type='text' class='form-control required company' placeholder='Company'  name='company' id='".$all_masters['id']."' title='Company' value='".$all_masters['company']."' />
  <div style='color:green;display:none;text-align:center;margin:10px' class='company_success success_msg' id='company_succcess_".$all_masters['id']."'><font >Updated Successfully!</font></div>
  <div style='color:red;display:none;text-align:center;margin:10px' class='company_error' id='company_error_".$all_masters['id']."'><font >Valid email address is required!</font></div>
                  </td>
                  
                                <td align='center' data-order='".$all_masters['master_name']."'>
                                <a href='#' style='' onclick='getMasterEmailsSent(".$all_masters['id'].")'  class='prev-color' ><img src='images/file.png' title='Preview'><br><small>Preview (".$all_masters['total_email_sent'].")</small></a></td>

                  <td style='    word-break: break-word;'>
                    <div style='color:green;display:none;text-align:center;margin:10px' class='master_type_success success_msg' id='master_type_succcess_".$all_masters['id']."'><font >Updated Successfully!</font></div><select class='form-control required multiselect master_type_update'   multiple='multiple'  name='master_type[]' id='multi_select_".$all_masters['id']."' onchange=masterTypeChange('".$all_masters['id']."') >";
                  
                    foreach($all_master_types_array as $all_master_type){
                      $master_type_name = $all_master_type['master_type_name'];
                      $sel = "";
                      if(in_array($all_master_type['id'],$master_type)) $sel = " selected ";
                      echo "<option value='".$all_master_type['id']."' ".$sel.">".$master_type_name."</option>";
                    }                  
                 
                    echo"</select>
                   
                </td>";
                              
                  $total_email_sent_per_month = $common->total_email_sent_per_month();
                                
                                echo "<td style='width:15%'>";
                                 if($total_email_sent_per_month!=0) 
                                {
                                  echo '<a class="actionBtn notify" href="#" data-toggle="modal" data-target="#limit_email_modal"><img src="images/notificationNew.png" title="Notification"  /></a>';
                                }else
                                {
                                  echo "<a href='master-notify.php?id=".base64_encode($all_masters['id'])."&eid=".base64_encode($event_id).':'.base64_encode(rand(100,999))."' class='actionBtn notify'><img src='images/notificationNew.png' title='Notification'  /></a>";
                                }
                                echo "<a class='actionBtn edit' href='edit-master.php?id=".base64_encode($all_masters['id'])."&eid=".base64_encode($event_id).':'.base64_encode(rand(100,999))."' ><img src='images/editNew.png' title='Edit'></a>";

                                if($total_email_sent_per_month!=0) 
                                  {
                                    echo "<a class='actionBtn requestModal request'  data-toggle='modal' data-target='#limit_email_modal'   ><img src='images/requestNew.png' title='Request'  /></a>";
                                  }else
                                  {
                                    echo "<a class='actionBtn requestModal request' id='spid-".$all_masters['id']."' onClick='setSpeakerValue(\"".$all_masters['id']."\")' data-toggle='modal' data-target='#information_modal'   ><img src='images/requestNew.png' title='Request'  /></a>";
                                  }

                                  echo "<a class='actionBtn delete' style='border-right:0px;'  href='' onClick='confirmDelete(\"".base64_encode($all_masters['id']).':'.base64_encode($event_id)."\",\"all-masters.php\")'><img src='images/deleteNew.png' title='Delete'   /></a></td>
                              </tr>";
                           }
                           ?>
                     </tbody>
                  </table>
                    <div class="pagination" style="float:right" id="pagination_div">
                        <?php echo $pagination_array[1]; ?> 
                   </div>
                  <?php 

                     if(!count($all_masters_array)){
                      echo "<center>No Data Found!</center>'";
                     } 
                     ?>
               </div>
            </section>
         </div>
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <!-- /.row (main row) -->
   </section>
   <!-- /.content -->
</div>
<div class="modal fade information_modal" id="limit_email_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="width: 100% !important;border-radius: 0px;">
      <div class="modal-header" style="background: #007db7;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="images/cancel.png" width="20"></button>
        <h4 class="modal-title" id="myModalLabel" style="color: #fff;">Notify Masters</h4>
      </div>

      <div class="modal-body text-center" style="padding-top: 20px;padding-bottom: 25px;">
          <a class="font-bold" style="color: #A32857;display: table;margin: auto;font-size: 20px;margin-bottom: 10px;">
            Email limit exceeds for this subscription plan.
          </a><p style="color: #a32857;">Please upgrade your current plan. </p>
        </div>
    </div>
  </div>
</div>

<div class="modal fade information_modal" id="information_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="width: 100% !important;border-radius: 0px;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="images/cancel.png" width="20"></button>
        <h4 class="modal-title" id="myModalLabel">Send Request</h4>
      </div>

      <div class="modal-body">
    <form method="post" action="include/form_submits.php"  id="information_form">
        <h5 class="modalHd"><img src="images/tap.png" width="20"> Trigger: 
          <select id="choose_category" style="border: 0px;outline: none !important;">
          <option value="missing_info" selected="true">Collect Missing Information</option>
        </select>
    </h5>
        <hr class="shadowHr"> 
     
      <div class="form-group" id="info_option_div" style="" >
        <div class="formbdy">
          <label class="leftAbso">Select</label>
          <select  name="multiselect_all_section[]" class="form-control multiselect_all_section"   multiple="multiple" id="multiselect_all_section"  >
                  <option value="is_personal_details">Personal Details</option>
                  <option value="is_address" >Address</option>
                  <option value="is_social_media_info">Social Media Information</option>
             </select>
        </div>
      </div>



      <h5 class="modalHd"><img src="images/request.png" width="30"> Request an update</h5>
        <hr class="shadowHr">
        <div class="formbdy">

          
        </div>
        <div class="formbdy">
          <div class="form-group">
            <label><img src="images/schedule.png"> Schedule</label>
            <select  class="form-control" name="schedule_option" id="schedule_option">
              <option value="send_now">Send It Right Away</option>
              <option value="send_later">Schedule It</option>
            </select>
          </div>
          
        </div>

        <div class="formbdy" id="schedule_datetime_div" style="display: none;">
          <div class="form-group">
            <label><img src="images/schedule-2.png"> Schedule It</label>
            <input type="text" class="form-control form_datetime" placeholder="Please select Date and Time" name="schedule_datetime" id="schedule_datetime">
          </div>
          
        </div>

        <div class="formbdy">
          <div class="form-group">
            <label><img src="images/message.png"> Message</label>
            <textarea class="form-control" name="info_msg" value="We are so excited to have you as a part of our event. In order to communicate effectively we would need some additional information.">We are so excited to have you as a part of our event. In order to communicate effectively we would need some additional information.</textarea>
          </div>
          
        </div>
        <div class="sendBtn text-right"> 
          <input type="hidden" id="timezone" name="timezone" value=""/>

          <input type="hidden" name="action" id="action" value="">
          <input type="hidden" name="current_event_id" id="current_event_id" value="<?php echo $event_id; ?>">
          <input type="hidden" name="info_modal_userid" id="info_modal_userid" value="">
          
          <button type="button" id="info_submit" class="btn btn-success">Send</button>
        </div>

       </form>
        </div>
    </div>
  </div>
</div>




<div class="modal fade information_modal" id="create_speaker_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="width: 100% !important;border-radius: 0px;">
      <div class="modal-header" style="background: #007db7;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="images/cancel.png" width="20"></button>
        <h4 class="modal-title" id="myModalLabel" style="color: #fff;">Create New Master</h4>
      </div>

      <div class="modal-body">
          <a id="search_from_db" class="text-center text-center font-sem-bold" style="color: #A32857;display: table;margin: auto;">
            <img src="images/database.svg" style="margin-bottom: 5px;" width="30"><br>
            Search From Database
          </a>
          <div class="orDivider font-sem-bold">OR</div>
          <a href="new_master.php?eid=<?php echo base64_encode($event_id);?>:<?php echo base64_encode(rand(100,999));?>" class="text-center text-center font-sem-bold" style="color: #007DB7;display: table;margin: auto;">
            <img src="images/new-user-blue.svg" style="margin-bottom: 5px;" width="30"><br>
            Create New
          </a>
        </div>
    </div>
  </div>
</div>

<div class="modal fade information_modal" id="limit_speaker_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="width: 100% !important;border-radius: 0px;">
      <div class="modal-header" style="background: #007db7;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="images/cancel.png" width="20"></button>
        <h4 class="modal-title" id="myModalLabel" style="color: #fff;">Create New Speakers</h4>
      </div>

      <div class="modal-body text-center" style="padding-top: 20px;padding-bottom: 25px;">
          <a class="font-bold" style="color: #A32857;display: table;margin: auto;font-size: 20px;margin-bottom: 10px;">
            Contact limit exceeds for this subscription plan.
          </a><p style="color: #a32857;">Please upgrade your current plan. </p>
        </div>
    </div>
  </div>
</div>

<!-- Modal 3 -->
<div class="modal fade information_modal" id="speakerfromDb" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static">
 <div class="modal-dialog" role="document">
    <div class="modal-content" style="width: 100% !important;border-radius: 0px;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="images/cancel.png" width="20"></button>
        <h4 class="modal-title" id="myModalLabel">Search From Database</h4>
      </div>

      <div class="modal-body">
            <table id=" " class="table test1 table-bordered table-responsive" style="width:100%">
              <thead>
                <tr>
                   <th></th>
                  <th>Full Name</th>
                  <th>Email Address</th>
                  <th>Company</th>
                  <th>Job Title</th>
                </tr>
              </thead>
             <tbody style="text-align: left;" id="master_popup">
                <?php
                 // foreach($sponsors_array as $resource){    
                 //  echo "<tr>
                 //          <td><input type='checkbox' name='selected_resource' value='".$resource['id']."' class='selected_resource'></td>
                 //          <td>".$resource['master_name']."</td>
                 //          <td>".$resource['email_id']."</td>
                 //          <td>".$resource['company']."</td>
                 //          <td>".$resource['job_title']."</td>
                 //        </tr>";
                 //      }
                ?>
               
              </tbody>
            </table>

        <div class="text-right">
            <input type="button" name="resource_submit" id="resource_submit" onclick="submitForm(this);" class="btn btn-success" style="margin-top: 5px;" disabled="true" value="Add">
          </div>
        </div>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade information_modal" id="information_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="width: 100% !important;border-radius: 0px;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="images/cancel.png" width="20"></button>
        <h4 class="modal-title" id="myModalLabel">Email Send</h4>
      </div>

      <div class="modal-body"> 
        <table id="" class="table table-bordered test1 table-responsive" style="width:100%">
                     <thead>
                        <tr>
                           <th style='display:none'>id</th>
                           <th>Email Subject</th>
                           <th>Sent By</th>
                           <th>Date</th>
                           <th style="min-width: 100px;">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr>
                                <td style='display:none'>39</td>
                                <td>Executive</td>
                                <td>Anweshan</td>
                                <td>14-Jan-2019</td>
                                <td style="color: #0283A3; ">Opened</td>
                              </tr>
                                  <tr>
                                <td style='display:none'>39</td>
                                <td>Executive</td>
                                <td>Anweshan</td>
                                <td>14-Jan-2019</td>
                                <td style="color: #0283A3; ">Opened</td>
                              </tr>
                                  <tr>
                                <td style='display:none'>39</td>
                                <td>Executive</td>
                                <td>Anweshan</td>
                                <td>14-Jan-2019</td>
                                <td style="color: #0283A3; ">Opened</td>
                              </tr>
                                                </tbody>
                  </table>

        </div>
    </div>
  </div>
</div>
<div class="modal fade sp_modal" id="upload_master_popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
<div class="modal-dialog" role="document">
   <div class="modal-content" style="width: 100% !important;border-radius: 0px;">
     <div class="modal-header">
       <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="images/cancel.png" width="20"></button>
       <h4 class="modal-title" id="myModalLabel">Uploaded Master Data</h4>
     </div>

     <div class="modal-body">
           <table id="datatable15" class="table table-bordered table-responsive dtTable" class="display" cellspacing="0" width="100%">
             <thead>
               <tr>
                 <th>Master Name</th>
                 <th>Master Email</th>
                 <th >Company</th>
                 <th>Contact</th>
               </tr>
             </thead>
            <tbody style="text-align: left;" id="master_attach">
               
              
             </tbody>
           </table>
           <p> <span style="color:red;">* Duplicate records are marked in red. Those will be discarded automatically.</span> </p>
       <div class="text-right">
           <input type="button" name="cancel_sub" id="cancel_sub" class="btn btn-danger" style="margin-top: 5px;" value="Cancel">
           <input type="button" name="proceed_submit" id="proceed_submit" class="btn btn-success" style="margin-top: 5px;"  value="Proceed">
         </div>
       </div>
   </div>
 </div>
</div>
<style type="text/css">
   #upload_master_popup .modal-dialog{width: 70%;}
</style>




<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="bower_components/raphael/raphael.min.js"></script>
<script src="bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>

<!-- jQuery Knob Chart -->
<script src="bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="bower_components/moment/min/moment.min.js"></script>
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<!-- Slimscroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!--<script src="dist/js/pages/dashboard.js"></script>-->
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script><script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

<script>
    
  var j = jQuery.noConflict();
      /*setTimeout(function() { */
        j( document ).ready(function() {
           var is_exists = "<?php echo $is_exists; ?>";
           if(is_exists == '1'){ 
            $('#delete_btn').show();
           }

           j("#search_from_db").click(function () {
            j('#create_speaker_modal').modal('hide');
              j('#speakerfromDb').modal('show');
              load_masters_to_popup();
          });

          var up_id = "<?php echo $is_upload; ?>";
          var event_id = "<?php echo $event_id;  ?>";
          // alert(event_id);

          if(up_id == '1'){  

          $.ajax({
               type: "POST",
               url: "ajaxCalls.php",               
               data: {"action": "fetch_all_master_after_upload", "event_id" : event_id },
               dataType: "json",
               success: function(data) { 
                // alert(data.length);
                  //destroy_datatable();
                 var old_notes_html = '';

                 for(var i=0; i<data.length; i++){

                        if(data[i].is_duplicate != '1')
                        {
                         old_notes_html += '<tr><td>'+data[i].master_name+'</td><td>'+data[i].email_id+'</td><td>'+data[i].company+'</td><td>'+data[i].phone+'</td></tr>';
                        }else
                        {
                           old_notes_html += '<tr style="color:red;"><td>'+data[i].master_name+'</td><td>'+data[i].email_id+'</td><td>'+data[i].company+'</td><td>'+data[i].phone+'</td></tr>';
                        }

                  } 
                 j("#upload_master_popup").modal('show');
                 $("#master_attach").empty();
                 $("#master_attach").append(old_notes_html);
                  jQuery('.dtTable').DataTable();

               }
          });          

    }

        var tz = jstz.determine(); // Determines the time zone of the browser client
        var timezone = tz.name(); //'Asia/Kolhata' for Indian Time.
        $("#timezone").val(timezone);


      });

        document.onreadystatechange = function () {
          $("#loader_div").show();
      $('body').addClass('stop-scrolling');
          var state = document.readyState
          if (state == 'complete') {
            $("#loader_div").hide();
            $('body').removeClass('stop-scrolling');
                 // document.getElementById('interactive');
                 // document.getElementById('load').style.visibility="hidden";
          }
      }

  function master_pre_upload_loader()
   {
     $("#loader_div").show();
      $('body').addClass('stop-scrolling');
   }

     function hideloader(){
    setTimeout(function() {
             $("#loader_div").hide();
        }, 3000); 
  }

  function load_masters_to_popup()
    {
       $("#loader_div").show();
      $('body').addClass('stop-scrolling');
        var event_id = "<?php echo $event_id; ?>";
          $.ajax({
                type: "POST",
                url: "ajaxCalls.php",
                dataType: "json",
                data: {"action": "fetch_masters_for_popup", "event_id" : event_id },
                success: function(data) { 
                  $("#loader_div").hide();
            $('body').removeClass('stop-scrolling');
                   jQuery('.test1').DataTable().destroy(); 
                   var speaker_data = '';

                  for(var i=0; i<data.length; i++){
                         speaker_data += '<tr><td><input type="checkbox" name="selected_resource" value='+data[i].id+' class="selected_resource"/></td><td>'+data[i].master_name+'</td><td>'+data[i].email_id+'</td><td>'+data[i].company+'</td><td>'+data[i].job_title+'</td></tr>';
                  } 
                  $("#master_popup").empty();
                  $("#master_popup").append(speaker_data);
                  jQuery('.test1').DataTable();

                }
           });
    }


</script>
<!---- Editor ------------>
    
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script>tinymce.init({ selector: ".editor",
      height: 400,
      theme: "modern",
      plugins: [
      "advlist autolink lists link image charmap print preview hr anchor pagebreak",
      "searchreplace wordcount visualblocks visualchars code fullscreen",
      "insertdatetime media nonbreaking save table contextmenu directionality",
      "emoticons template paste textcolor colorpicker textpattern codesample"
      ],
      toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
      toolbar2: "print preview media | forecolor backcolor emoticons | codesample",
      templates: [
      { title: "Test template 1", content: "Test 1" },
      { title: "Test template 2", content: "Test 2" }
      ],
    init_instance_callback: function (editor) {
          editor.on("click", function (e) { 
            console.log(e.target.nodeName);
            if(e.target.nodeName=="IMG"){ $(".cropme").click(); return false;}
          });
          editor.on("KeyDown", function (e) {
            if ((e.keyCode == 8 || e.keyCode == 46)) { // delete & backspace keys
              if(e.target.nodeName=="IMG"){ $(".cropme").click(); return false;}
            }
          });
        
          },
      content_css: [
      "//fonts.googleapis.com/css?family=Lato:300,300i,400,400i",
      "https://staging.speakerengage.com/css/codepen.min.css",
      
      ] });
      function applyMCE() {
         $(".editor").each(function(){
           tinyMCE.EditorManager.execCommand("mceRemoveEditor", true, $(this).attr("id"));
        tinyMCE.EditorManager.execCommand("mceFocus", false, $(this).attr("id"));                    
        tinyMCE.EditorManager.execCommand("mceAddEditor", true, $(this).attr("id"));
         });
        
    }
     
     tinyMCE.EditorManager.execCommand("mceRemoveEditor", true, "address");
     tinyMCE.EditorManager.execCommand("mceRemoveEditor", true, "additional_code");
    </script>
    <!---- Modal popup---->
    
    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" id="modalOpen" style="display:none">Open Modal</button>
    <div class="modal fade modal-md in darkHeaderModal" id="myModal" role="dialog" style="">
     
   </div>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.css" integrity="sha256-JHRpjLIhLC03YGajXw6DoTtjpo64HQbY5Zu6+iiwRIc=" crossorigin="anonymous" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="js/custom.js"></script>
<!-- <link rel="stylesheet" href="dist/css/bootstrap-multiselect.css" type="text/css">
<script type="text/javascript" src="dist/js/bootstrap-multiselect.js"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.js" integrity="sha256-apFUVcutYBHTJh5O835gpzGcVk3v6iUxg38lKBpQMDA=" crossorigin="anonymous"></script>
<script type="text/javascript">
     
    
       $(".filterText").click(function(){
         $('.filteSearch').slideToggle(200);
       });
       $(".searchImge").click(function(){
         $('.filteSearch').slideToggle(200);
       });
   </script>
<script>
//   function initMultiSelect(){

//       $(".multiselect").multiselect({
//     includeSelectAllOption: true,
//     maxHeight: 400
//     });
//        $(".multiselect_all_section").multiselect({
//     includeSelectAllOption: true,
//     maxHeight: 400
//     });
//     }

    
//   function destroyMultiselect(){

//       $(".multiselect").multiselect("destroy");
//     }

//      function destroyMultiselectrequest(){
//        $(".multiselect_all_section").multiselect("destroy");
//     }
//   destroyMultiselect();

//   initMultiSelect();
// function fetch_status(){
//     $.ajax({
//         type: "POST",
//         url: "ajaxCalls.php",
//         async:false,
//         data: {"template_type":$('#template_type').val(),"action":"fetchStatusBasedonType"} ,
//         success: function(data) {
          
//         $("#status_id").html(data);
//         destroyMultiselect();
//         initMultiSelect();
        
//         }
//       });
//   }
$(".jcrop-holder").click(function(e){ e.preventDefault(); });
</script>


<!-- DataTables ---->
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jstimezonedetect/1.0.4/jstz.min.js">
    </script>

<script type="text/javascript">
 var oTable;
$(document).ready(function() {
   oTable = $(".test1").DataTable( {
        "order": [[ 0, "desc" ]],
        "sDom": 'Rlfrtip',
        "bLengthChange": false
    } );

});
// $(document).ready(function() {
//    $("#loader_div").show();
      $('body').addClass('stop-scrolling');
// });
//   var j_dataTable = $.noConflict();
// j_dataTable(document).ready(function() {
//   var oTable = j_dataTable(".test1").DataTable();
// });



</script>
<script type="text/javascript">
        function submitForm(btn) {
            btn.disabled = true;
        }

 $(document).on('change', "input[name='selected_resource']", function(){ 
      var resource_array = [];
        var all_resource = '';
        $.each($("input[name='selected_resource']:checked"), function(){            
            resource_array.push($(this).val());
        });
        all_resource = resource_array.join(",");

        if(all_resource != ''){
           $("#resource_submit").prop('disabled', false);
        }else{
          $("#resource_submit").prop('disabled', true);
        }
  });

    var resource_array = [];
    var all_resource = '';
    var oTable; 
    $( "#resource_submit" ).click(function() {
      $("#loader_div").show();
      $('body').addClass('stop-scrolling');
      oTable = jQuery('.test1').dataTable();
        var sData = $('input', oTable.fnGetNodes()).serialize();
        var spk_id_arr = sData.split('selected_resource=');
        var resource_array = [];
       for (var i = 1; i < spk_id_arr.length; ++i) {
            var usr_id = spk_id_arr[i].replace('&', '');
            resource_array.push(usr_id);

        }

        var evt_id="<?php echo base64_encode($event_id); ?>";
        var rand_num = "<?php echo base64_encode(rand(100,999));?>";
        var event_id="<?php echo $event_id; ?>";
        // var resource_array = [];
        // var all_resource = '';
        // $.each($("input[name='selected_resource']:checked"), function(){            
        //     resource_array.push($(this).val());
        // });
        all_resource = resource_array.join(",");
         $("#speakers_list").val(all_resource);
        if(all_resource != ''){

            $.ajax({
                      type: "POST",
                      url: "api.php",
                      //dataType: "json",
                      //contentType: "application/json",
                       //dataType: "json",
                       data: {"action": "insert_master_from_master_popup", "resource_ids":all_resource,"event_id":event_id },
                      success: function(data){
                        $("#loader_div").hide();
            $('body').removeClass('stop-scrolling');
                              window.location.href = "all-masters.php?created-success&eid="+evt_id+":"+rand_num;
                           }
                    }); // end of ajax

        }

    });
</script>



<script>

  
function Validate(oForm) {
  var _validFileExtensions = [".csv",".CSV"];  
    var arrInputs = $("#"+oForm);
    for (var i = 0; i < arrInputs.length; i++) {
        var oInput = arrInputs[i];
        if (oInput.type == "file") {
            var sFileName = oInput.value;
            if (sFileName.length > 0) {
                var blnValid = false;
                for (var j = 0; j < _validFileExtensions.length; j++) {
                    var sCurExtension = _validFileExtensions[j];
                    if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                        blnValid = true;
                        break;
                    }
                }
                
                if (!blnValid) {
                    arrInputs.val('');
                    alert("Please upload valid csv file!");
                    return false;
                }else{
                   $("#master_upload_btn").prop("disabled", false);
                  
                }
            }
        }
    }
  
    return true;
}



/* ****************** All ajaxCalls ******************** */

$(document).on('input','.master_first_name',function () {

  
  $('.master_first_name_succcess').hide();
  if(id = $(this).attr('id')){
    $.ajax({
      type: "POST",
      url: "api.php",
      dataType: "json",
      data: {"action": "master_update_master_first_name", "rec_id":$(this).attr('id'),"master_first_name":$(this).val() },
      success: function(data){
          $('.master_first_name_succcess,.master_first_name_error,.success_msg').hide();
          $('#master_first_name_succcess_'+id).show();
      },
    error: function() {
      swal({
          type: 'error',
          title: 'Oops...',
          text: "Something went wrong! Please try again"
        });
       }
  }); // end of ajax

  }
});


$(document).on('input','.master_last_name',function () {
  $('.master_last_name_succcess').hide();
  if(id = $(this).attr('id')){
    $.ajax({
      type: "POST",
      url: "api.php",
      dataType: "json",
      data: {"action": "master_update_master_last_name", "rec_id":$(this).attr('id'),"master_last_name":$(this).val() },
      success: function(data){
          $('.master_last_name_succcess,.master_last_name_error,.success_msg').hide();
          $('#master_last_name_succcess_'+id).show();
      },
    error: function() {
      swal({
          type: 'error',
          title: 'Oops...',
          text: "Something went wrong! Please try again"
        });
       }
  }); // end of ajax

  }
});

$(document).on('input','.email_id',function () {
  $('.email_id_succcess,.email_id_error,.email_id_dup').hide();
  var id = $(this).attr('id');
  var VAL = $(this).val();
  var event_id = "<?php echo $event_id; ?>";

  //var email = new RegExp('^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$');
  var email_id_regex = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
  var x = email_id_regex.test(VAL);
  console.log(x);
  if (x==true) {
    
          $.ajax({
                      type: "POST",
                      url: "api.php",
                      dataType: "json",
                      data: {"action": "master_update_email_id","event_id":event_id,"rec_id":$(this).attr('id'),"email_id":$(this).val() },
                      success: function(data){
                        if(data[0]['is_duplicate'] != true){
                          $('.email_id_succcess,.email_id_error,.success_msg').hide();
                              $('#email_id_succcess_'+id).show();

                          }else{
                            $('.success_msg').hide();
                            $('#email_id_dup_'+id).show();
                          }
                              
                      },
                        error: function() {
                            swal({
                                  type: 'error',
                                  title: 'Oops...',
                                  text: "Something went wrong! Please try again"
                                });
                           }
                    }); // end of ajax
   
    }
  if (x==false) {
    $('.email_id_succcess,.email_id_error').hide();
    $('#email_id_error_'+id).show();
  }
    
  });



$(document).on('input','.job_title',function () {
  $('.job_title_succcess').hide();
  if(id = $(this).attr('id')){
    $.ajax({
    type: "POST",
    url: "api.php",
    dataType: "json",
    data: {"action": "master_update_job_title", "rec_id":$(this).attr('id'),"job_title":$(this).val() },
    success: function(data){
        $('.job_title_succcess,.company_error,.success_msg,.error_massage').hide();
        $('#job_title_succcess_'+id).show();
    },
    error: function() {
      swal({
          type: 'error',
          title: 'Oops...',
          text: "Something went wrong! Please try again"
        });
       }
  }); // end of ajax
  } 
});

$(document).on('input','.phone',function () {
      $('.phone_succcess, .phone_error,.success_msg').css('display','none');
      var event_id =  "<?php echo $event_id; ?>";
    var id = $(this).attr('id');
    var VAL = $(this).val();
    var x = true;

        var target_val=VAL.replace(/[^0-9\-]/g, '');
    var formatted_number =  target_val.substr(0, 15);
    $(this).val(formatted_number.substr(0, 15));  

    if (x == true) {
      console.log("done");
        // $('.phone_succcess,.phone_error').hide();
            $.ajax({
                      type: "POST",
                      url: "api.php",
                      dataType: "json",
                      data: {"action": "master_update_phone", "rec_id":$(this).attr('id'),"phone":$(this).val(),"event_id": event_id },
                      success: function(data){
                              $('.phone_succcess,.phone_error').hide();
                              $('#phone_succcess_'+id).show();
                      },
                        error: function() {
                            swal({
                                  type: 'error',
                                  title: 'Oops...',
                                  text: "Something went wrong! Please try again"
                                });
                           }
                    }); // end of ajax   
        } 
  });


$(document).on('change','.status_update',function () {
    //id=$("#id_cust").val();
     var status_id = $(this).val();
     var rec_id = $(this).find('option[data-id]').data('id');
     //alert("TD ID " + tdid);

     $.ajax({
                      type: "POST",
                      url: "api.php",
                      //contentType: "application/json",
                       dataType: "json",
                       data: {"action": "update_master_status", "rec_id":rec_id,"status_id":status_id },
                      success: function(data){
                             /* swal({ 
                                        title: "Success",
                                        text: "Status has been updated successfully",
                                        type: "success", 
                                        showCancelButton: false

                                    }).then(result => {
                                      if (result.value) {
                                         location.reload();
                                      } 
                                    });*/
                $('.master_status_success, .success_msg').hide();
                              $('#master_status_succcess_'+rec_id).show();
                      },
                        error: function() {
                            swal({
                                  type: 'error',
                                  title: 'Oops...',
                                  text: "Something went wrong! Please try again"
                                });
                           }
                    }); // end of ajax
   
    
    
  });

$(document).on('input','.company',function () {
  var event_id =  "<?php echo $event_id; ?>";
  $('.company_succcess').hide();
  if(id = $(this).attr('id')){
    $.ajax({
    type: "POST",
    url: "api.php",
    dataType: "json",
    data: {"action": "master_update_company", "rec_id":$(this).attr('id'),"company":$(this).val(),"event_id":event_id },
    success: function(data){
        $('.company_succcess,.company_error,.success_msg').hide();
        $('#company_succcess_'+id).show();
    },
    error: function() {
      swal({
          type: 'error',
          title: 'Oops...',
          text: "Something went wrong! Please try again"
        });
       }
  }); // end of ajax
  }
});  

function masterTypeChange(id) {
  var event_id="<?php echo $event_id; ?>";
  $.ajax({
                      type: "POST",
                      url: "api.php",
                      //contentType: "application/json",
                       dataType: "json",
                       data: {"action": "update_master_type","event_id":event_id,"rec_id":id,"master_type_value":$('#multi_select_'+id).val().join(",") },
                      success: function(data){
                        //alert(data);
                       // alert(data['status_code']);
                              $('.master_type_succcess, .success_msg').hide();
                              $('#master_type_succcess_'+id).show();
                      },
                        error: function() {
                         // alert("err");
                            swal({
                                  type: 'error',
                                  title: 'Oops...',
                                  text: "Something went wrong! Please try again"
                                });
                           }
                    }); // end of ajax   
    
    
  }

        $(document).ready(function() {
          var event_id = "<?php echo $event_id; ?>";
       $.ajax({
                      type: "POST",
                      url: "ajaxCalls.php",
                       dataType: "json",
                       data: {"action": "master_get_revert_flag_data", "event_id":event_id },
                      success: function(data){
                        for(var i=0; i<data.length; i++){
                            var is_sent_count=data[i].is_sent;
                            var is_revert_flag=data[i].is_revert_flag;
                            var scheduld_cnt=data[i].scheduld_cnt;
                          }

                        if(is_sent_count<1 && is_revert_flag>0 && scheduld_cnt<1)
                        {
                          $("#revert").show();
                        }else
                        {
                          $("#revert").hide();
                        }
                        
                      }
                    }); // end of ajax
    });

  $( "#proceed_submit" ).click(function() {
    $(this).prop('disabled', true);
        $("#loader_div").show();
      $('body').addClass('stop-scrolling');
        var evt_id="<?php echo base64_encode($event_id); ?>";
        var rand_num = "<?php echo base64_encode(rand(100,999));?>";
        var event_id="<?php echo $event_id; ?>";

            $.ajax({
                      type: "POST",
                      url: "ajaxCalls.php",
                       data: {"action": "master_upload_proceed", "event_id":event_id },
                      success: function(data){
                        $("#loader_div").hide();
            $('body').removeClass('stop-scrolling');
                        if(data=='success')
                        {
                          window.location.href = "all-masters.php?upload_success&eid="+evt_id+":"+rand_num;
                        }else{
                          $("#proceed_submit").prop('disabled', false);
                        }
                        
                      }
                    }); // end of ajax
    });

    $( "#cancel_sub" ).click(function() {
      $("#loader_div").show();
      $('body').addClass('stop-scrolling');
        var event_id = "<?php echo $event_id; ?>";
        var evt_id="<?php echo base64_encode($event_id); ?>";
        var rand_num = "<?php echo base64_encode(rand(100,999));?>";

            $.ajax({
                      type: "POST",
                      url: "ajaxCalls.php",
                       data: {"action": "master_upload_cancel", "event_id":event_id },
                      success: function(data){
                        $("#loader_div").hide();
            $('body').removeClass('stop-scrolling');
                        if(data=='success')
                        {
                          window.location.href="all-masters.php?eid="+evt_id+":"+rand_num;
                        }
                        
                      }
                    }); // end of ajax
    });

    $( "#revert" ).click(function() {
      $("#loader_div").show();
      $('body').addClass('stop-scrolling');
        var event_id = "<?php echo $event_id; ?>";
        var evt_id="<?php echo base64_encode($event_id); ?>";
        var rand_num = "<?php echo base64_encode(rand(100,999));?>";
        var result = confirm("Are you sure you want to revert.");
          if (result) {
            $.ajax({
                      type: "POST",
                      url: "ajaxCalls.php",
                       data: {"action": "master_upload_revert", "event_id":event_id },
                      success: function(data){
                        $("#loader_div").hide();
                        $('body').removeClass('stop-scrolling');
                        // if(data=='success')
                        // {
                         window.location.href = "all-masters.php?revert_success&eid="+evt_id+":"+rand_num; 
                        //}
                        
                      }
                    }); // end of ajax
            } else {
                      location.reload();
                  }
    });

    if(window.location.href.indexOf("revert_success") > -1) {
       $('.revert_success').fadeIn(200).delay(2000).fadeOut(2000);
  }


</script>  
<script type="text/javascript">

 function Advanced_master_search()
{     
    $("#loader_div").show();
      $('body').addClass('stop-scrolling');         
    var master_name = $('#master_name').val();
    var master_email = $('#master_email').val();
    var contact = $('#contact').val();
    var company_name = $('#company_name').val();
    var master_type = $('#master_type').val();
    var event_id = <?php echo $event_id; ?>;

    var go = "success";
      if (master_name == "" && master_email == "" && contact == "" && company_name == "" && master_type == "")
      {
          alert('Please fill atleast one field.');
          go = "error";
          $("#loader_div").hide();
      }
                
        if (go == "success") {
           $.ajax({

               type: "POST",

               url: "master_advanced_search.php",

               data: {
                   master_name: master_name,
                   master_email: master_email,
                   contact: contact,
                   company_name: company_name,
                   master_type: master_type,
                   event_id: event_id

               },

               success: function(html) {
               $("#loader_div").hide();
               $('body').removeClass('stop-scrolling');
                $("#pagination_div").hide();
                  destroyMultiselect();
                  destroyMultiselect_missing_info();
                   $("#master_body").html(html).show();
                   jQuery(".multiselect").multiselect({
                    includeSelectAllOption: true,
                    maxHeight: 400
                    });
                    jQuery(".multiselect_all_section").multiselect({
                    includeSelectAllOption: true,
                    maxHeight: 400
                    });

               }

           });
         }
  }
function refresh_page()
{
  location.reload();
}

$("#searchbtnval").keyup(function() {
   var searchval=$('#searchbtnval').val();
   var event_id = <?php echo $event_id; ?>;
   var totatl_cnt=searchval.length;

    var go = "success";
      if (searchval == "")
      {
          // alert('Please fill atleast one field.');
          go = "error";
      }

      if(totatl_cnt=='' &&  totatl_cnt==' ') 
      {
        location.reload();
      }
        if(totatl_cnt>=3)
        {  
         $('#select_div').hide();   
        if (go == "success") {
           $.ajax({

               type: "POST",

               url: "master_normal_search.php",

               data: {
                   searchval: searchval,
                   event_id: event_id

               },

               success: function(html) {
                  $("#pagination_div").hide();
                  destroyMultiselect();
                  destroyMultiselect_missing_info();
                   $("#master_body").html(html).show();
                   jQuery(".multiselect").multiselect({
                    includeSelectAllOption: true,
                    maxHeight: 400
                    });
                    jQuery(".multiselect_all_section").multiselect({
                    includeSelectAllOption: true,
                    maxHeight: 400
                    });

               }

           });
         }
       }
       });

    var selectall_flag;
  $(document).on('change', "input[name='select_all']", function(){ 
    
      if($(this). is(":checked")){
        $('#delete_btn').show();
       selectall_flag=1;
      }
      else if($(this). is(":not(:checked)")){
        $('#delete_btn').hide();
        selectall_flag=0;
      }

      var $checkboxes = $('input[name="row_id"]');
        var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
        if(countCheckedCheckboxes<1)
        {
          $('#delete_btn').hide();
        }

      var event_id = "<?php echo $event_id; ?>";
              $.ajax({
                      type: "POST",
                      url: "api.php",
                       data: {"action": "set_session_select_all_masters", "selectall_flag":selectall_flag,"event_id":event_id },
                      success: function(data){
                            
                           }
                    }); // end of ajax
  });

  function check_uncheck_checkbox(isChecked) {
    if(isChecked) {
        $('input[name="row_id"]').each(function() { 
            this.checked = true; 
        });
    } else {
        $('input[name="row_id"]').each(function() {
            this.checked = false;
        });
    }
}

   var is_checked;
   $(document).on('change', "input[name='row_id']", function(){ 
      if($(this). is(":checked")){
         $('#delete_btn').show();
       is_checked=1;
      }
      else if($(this). is(":not(:checked)")){
         //$('#delete_btn').hide();
          $("#example-select-all"). prop("checked", false);
        is_checked=0;
      }

      var $checkboxes = $('input[name="row_id"]');
        var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
        if(countCheckedCheckboxes<1)
        {
          $('#delete_btn').hide();
        }

       var event_id = "<?php echo $event_id; ?>";
       $.ajax({
                type: "POST",
                url: "api.php",
                data: {"action": "check_uncheck_call_masters", "is_checked":is_checked,"spk_id":$(this).val(),"event_id":event_id },
                success: function(data){
                            
                }
              }); // end of ajax
    });

    function confirmDeleteAll()
    {
      $("#loader_div").show();
      $('body').addClass('stop-scrolling');
      var event_id = "<?php echo $event_id; ?>";
      var evt_id="<?php echo base64_encode($event_id); ?>";
      var rand_num = "<?php echo base64_encode(rand(100,999));?>";

      var result = confirm("Are you sure you want to delete.");
            if (result) {  
                $.ajax({
                    type: "POST",
                    url: "api.php", //calling page from same directory 
                    data: {"action": "delete_multi_masters","event_id":event_id },
                    dataType: "json",
                    success: function (response) {
                      $("#loader_div").hide();
            $('body').removeClass('stop-scrolling');
                        if (response[0].status == 'success') { // compare Response from server .
                           Swal.fire({
                                    type: 'success',
                                    title: 'Success',
                                    text: 'Deleted Successfully.',
                                    allowOutsideClick: false
                                  }).then(okay => {
                                       if (okay) {
                                         window.location.href= "all-masters.php?eid="+evt_id+":"+rand_num;
                                      }
                                    });
                         
                        } else
                        {
                            alert("Something went wrong ,Please try again.");
                        }

                    }//Success function end here 

                });
             } else {
                      window.location.href= "all-masters.php?eid="+evt_id+":"+rand_num;
                  }
   
    }

</script>

<script type="text/javascript">
  $('#masters_upload').bind('change', function () {
  var filename = $("#masters_upload").val();  

  //Limit 10 mb 10240000
  if( $("#masters_upload")[0].files[0].size <= 10240000){  
      if (/^\s*$/.test(filename)) {
        $(".file-upload").removeClass('active');
        $("#noFile").text("No file chosen..."); 
      }
      else {
        $(".file-upload").addClass('active');
        $("#noFile").text(filename.replace("C:\\fakepath\\", "")); 
      }
  }else{
    $('#masters_upload').val('');
     $("#noFile").text("No file chosen...");

        Swal.fire({
        type: 'error',
        title: 'Oops...',
        text: 'File size must be less than 10 mb!'
      });
  }


});

      $(document).on('change','.master_select',function () {
      $("#loader_div").show();
      $('body').addClass('stop-scrolling');
      var event_id = "<?php echo $event_id; ?>";
      var evt_id="<?php echo base64_encode($event_id); ?>";
      var rand_num = "<?php echo base64_encode(rand(100,999));?>";
      var status_id = $(this).val();

                $.ajax({
                    type: "POST",
                    url: "api.php", //calling page from same directory 
                    data: {"action": "update_multi_master","event_id":event_id,"status_id":status_id},
                    dataType: "json",
                    success: function (response) {
                      $("#loader_div").hide();
                      $('body').removeClass('stop-scrolling');
                        if (response[0].status == 'success') { // compare Response from server .
                           Swal.fire({
                                    type: 'success',
                                    title: 'Success',
                                    text: 'Updated Successfully.',
                                    allowOutsideClick: false
                                  }).then(okay => {
                                       if (okay) {
                                         window.location.href= "all-masters.php?eid="+evt_id+":"+rand_num;
                                      }
                                    });
                         
                        } else
                        {
                            alert("Something went wrong ,Please try again.");
                        }

                    }//Success function end here 

                });
             
   
    
    
  });


  $(document).on('change','#choose_category',function () {

   var category_val = $( "#choose_category option:selected" ).val();
    if(category_val == 'missing_doc'){    
      $("#doc_option_div").show();    
      $("#info_option_div").hide();
    }else{
      $("#doc_option_div").hide();
      $("#info_option_div").show();
    }
 });

  function setSpeakerValue(master_id){
    $("#info_modal_userid").val(master_id);     
   }

$(document).on('click','#info_submit',function () {
  
  var cat_v = $( "#choose_category option:selected" ).val();

    var topic_selected = $("#multiselect_all_section").val();
    if(topic_selected != ''){
      $(".multiselect-native-select").removeClass('err_cls');
      $("#action").val("information_form_submit_master");
      $("#information_form").submit();
    }else{
      $(".multiselect-native-select").addClass('err_cls');
    }   
  
   });


    $(document).on("change", "#schedule_option", function () {
       var opt_val = $(this).val();
       if(opt_val == 'send_later'){
        $("#schedule_datetime_div").show();
       }else if (opt_val == 'send_now'){
        $("#schedule_datetime_div").hide();
       }   
          
  });

</script>


    <link rel="stylesheet" href="dist/css/bootstrap-multiselect.css" type="text/css">
    <script type="text/javascript" src="dist/js/bootstrap-multiselect.js"></script>
    <script type="text/javascript" src="js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
    <script type="text/javascript" src="js/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>
<script type="text/javascript">

  $.noConflict();

  jQuery(".multiselect").multiselect({
      includeSelectAllOption: true,
      maxHeight: 400,
      }); 

  jQuery(".multiselect_all_section").multiselect({
      includeSelectAllOption: true,
      maxHeight: 400,
      }); 

  function destroyMultiselect_missing_info(){
     jQuery(".multiselect_all_section").multiselect("destroy");
    }

   function destroyMultiselect(){
     jQuery(".multiselect").multiselect("destroy");
    }



    jQuery(".form_datetime").datetimepicker({
        format: "dd-M-yyyy hh:ii",
        autoclose: true,
        todayBtn: true,
        startDate: new Date,
        minuteStep: 60
    });
  </script>
</body>
</html>

<?php version_footer(); ?>

