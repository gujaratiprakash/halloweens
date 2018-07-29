<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST'); 
include('config.php');

//date_default_timezone_set('Asia/Kolkata');
$source = $_GET['source'];
$destination = $_GET['destination'];
//$starttime = date('12:00:00');
$starttime = date('H:i:s');

$user = array();

/*$sql="select * from routes join bus_timetable on bus_timetable.rid = routes.id join route_list on routes.routeno=route_list.routeno where routes.routeno in (SELECT distinct (s.routeno) FROM (SELECT routeno FROM `bus_timetable` join routes on bus_timetable.rid = routes.id where routes.station_name = '$destination' and bus_timetable.start > '$starttime') AS s,(SELECT routeno FROM `bus_timetable` join routes on bus_timetable.rid = routes.id where routes.station_name = '$source' and bus_timetable.start > '$starttime') AS d where s.routeno = d.routeno) and routes.station_name = '$source' and bus_timetable.start > '$starttime' order by bus_timetable.start ASC";*/


$fsql = "SELECT distinct (s.routeno) FROM (SELECT routeno FROM `bus_timetable` join routes on bus_timetable.rid = routes.id where routes.station_name = '$destination' and bus_timetable.start > '$starttime') AS s,(SELECT routeno FROM `bus_timetable` join routes on bus_timetable.rid = routes.id where routes.station_name = '$source' and bus_timetable.start > '$starttime') AS d where s.routeno = d.routeno";

$fsql = "SELECT s1.route_no as routeno FROM (SELECT r.route_no FROM m_routes r
JOIN m_schedule s ON s.route_id = r.id
JOIN m_stations st ON st.id = s.station_id
WHERE st.name = '$source'
ORDER BY s.time ASC) as s1
JOIN
(SELECT r.route_no FROM m_routes r
JOIN m_schedule s ON s.route_id = r.id
JOIN m_stations st ON st.id = s.station_id
WHERE st.name = '$destination'
ORDER BY s.time ASC) AS s2 ON s1.route_no = s2.route_no
GROUP BY s1.route_no";

$fresult =mysqli_query($con,$fsql);
$row = mysqli_fetch_array($fresult);

$rtsql = "SELECT * FROM `routes` WHERE `routeno` = '".$row['routeno']."'";	
$result = mysqli_query($con,$rtsql);
$sid = 0;
$did = 0;
while($row = mysqli_fetch_array($result))
{
	if($row['station_name']==$source){$sid = $row['id'];}
	if($row['station_name']==$destination){$did = $row['id'];}
}
if($sid<$did)
	$waytype="Down";
else
	$waytype="Up";	
	
$sql="select * from routes join bus_timetable on bus_timetable.rid = routes.id join route_list on routes.routeno=route_list.routeno where routes.routeno in (".$fsql.") and routes.station_name = '$source' and bus_timetable.start > now() and route_list.way_type = '".$waytype."' order by bus_timetable.start ASC";
// echo $sql;
// exit;
$result = mysqli_query($con,$sql)or die('query not fire');


while($res=mysqli_fetch_array($result))
{
	$temp['id'] =$res['id'];
	$temp['routeno'] =$res['routeno'];
	
	$date = $res['start'];
	$temp['start'] = date('h:i:s A', strtotime($date));
	$temp['station_name'] = $res['route_title'];
	$temp['way_type'] = $res['way_type'];
	//$temp['taken_time'] =$res['taken_time'];
	//$temp['rid'] =$res['rid'];
	
	//$temp['cycle'] =$res['cycle'];
	$blank_arr[] = $temp;
	$user['busSearchFragmentModel'] = $blank_arr;
}
if(empty($user))
{
    $temp['id'] ="-1";
	$blank_arr[] = $temp;
	$user['busSearchFragmentModel'] = $blank_arr;
}
echo json_encode($user);
mysqli_close($con);
?>
