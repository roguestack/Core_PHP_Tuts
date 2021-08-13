<?php
include_once 'db_config.php';

$limit=5;
$page=1;

if($_POST['page']>1){
    $start=(($_POST['page']-1)* $limit);
    $page=$_POST['page'];
}else{
    $start=0;
}

$query="SELECT * FROM user_list";

if($_POST['query']!=""){
    $query.='WHERE uname LIKE "%'.str_replace('','%',$_POST['query']).'%"';
}
$query.='ORDER BY user_id ASC';
$filter_query=$query.'LIMIT'.$start.','.$limit.'';

$stmt=$conn->query($query);
$total_data=$stmt->rowCount();

$stmt=$conn->query($filter_query);
$result=$stmt->fetch();

$output='
    <label>Total Records: '.$total_data.'</label>
    <br>
    <div class="container">
    <h1 class="text-center">User Details</h1>
    <table id="existingData" class="table table-bordered">
        <thead style="background-color:#20639B;color:white;">
            <tr>
                <th>User Id</th>
                <th>User Name</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Country</th>
                <th>State</th>
                <th>City</th>
                <th>Profile Pic</th>
                <th>Action</th>
                <th>Action</th>
            </tr>
        </thead>
';
if($total_data>0){
    foreach($result as $row){
        $output.='
        <tbody>
            <tr>
                <td>'.$row["user_id"].'</td>;
                <td>'.$row["user_name"].'</td>
                <td>'.$row['fname'].'</td>
                <td>'.$row['lname'].'</td>
                <td>'.$row['eml'].'</td>
                <td>'.$row['gnd'].'</td>
                <td>'.$row['country_name'].'</td>
                <td>'.$row['state_name'].'</td>
                <td>'.$row['city_name'].'</td>
                <td>'.$row['img'].'</td>
                <td><input type="button" value="Edit" class="btn btn-primary"></td>
                <td><input type="button" value="Delete" class="btn btn-danger"></td>
            </tr>
        </tbody>
        ';
    }
}else{
    $output.='<tr><td colspan="12" align="center">No Data Found</td></tr>';
}
$output.='</table></div>
    <br>
    <div align="center">
    <ul class="pagination">
';

$total_links=ceil($total_data/$limit);
$previous_link='';
$next_link='';
$page_link='';

if($total_links>4){
    if($page<5){
        for($count=1;$count<=10;$count++){
            $page_array[]=$count;
        }    
        $page_array[]='...';
        $page_array[]=$total_links;
    }else{
        $end_limit=$total_links-5;
        if($page>$end_limit){
            $page_array[]=1;
            $page_array[]='...';
            for($count=$end_limit;$count<=$total_links;$count++){
                $page_array[]=$count;
            }
        }else{
            $page_array[]=1;
            $page_array[]='...';
            for($count=$page-1;$count<=$page+1;$count++){
                $page_array[]=$count;
            }
            $page_array[]='...';
            $page_array[]=$total_links;
        }
    }
}else{
    for($count=1;$count<=$total_links;$count++){
        $page_array[]=$count;
    }
}

for($count=0;$count<count($page_array);$count++){
    if($page==$page_array[$count]){
        $page_link.='
            <li class="page-item active">
                <a class="page-link" href="#">'
                    .$page_array[$count].
                    '<span class="sr-only">(Current)</span>
                </a>
            </li>
        ';
       
       
        $previous_id=$page_array[$count]-1;
        if($previous_id>0){
            '<li class="page-item">
                <a class="page-link" href="javascript:void(0)" data-page_number="'.$previous_id.'">Previous</a>
            </li>
        ';
        }else{
            $previous_link='
            <li class="page-item disabled">
                <a class="page-link" href="#">Previous</a>
            </li>
            ';
        }
        $next_id=$page_array[$count]+1;
        if($next_id>$total_links){
            $next_link='
            <li class="page-item disabled">
            <a class="page-link" href="#">Next</a>
        </li>
            ';
        }else{
            $next_link='
            <li class="page-item">
            <a class="page-link" href="javascript:void(0)" data-page_number="'.$next_id.'">Next</a>
            </li>';
        }
    }else{
        if($page_array[$count]=='...'){
            $page_link.='
            <li class="page-item disabled">
            <a class="page-link" href="#">...</a>
        </li>
            ';
        }
        else{
            $page_link.='
            <li class="page-item">
            <a class="page-link" href="javascript:void(0)" data-page_number="'.$page_array[$count].'">'.$page_array[$count].'</a>
        </li>
            ';
        }
    }
}

$output.=$previous_link.$page_link.$next_link;
echo $output;
?>