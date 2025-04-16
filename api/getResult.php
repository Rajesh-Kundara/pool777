<?php 
include('../common/config.php');

$response=array();
$response['matchesList']=array();
$response['couponsList']=array();

if(!empty($_GET['week'])){
	$week=$_GET['week'];
}else{
	$week="1";
}
				
$sql = "SELECT * FROM matches WHERE status='A'";
$stmt3 = $connection->query($sql);
if ( $stmt3 ){
	while( $row3 = $stmt3->fetch_assoc()){
		$class="";
		if($row3['isResultDeclared']){
			if(($row3['homeScore']==$row3['awayScore'])){
				if($row3['homeScore']>0 && $row3['isHomeWinner']>0){
					$result="Score Draw";
				}else{
					$result="No Score Draw";
				}
				$class="text-secondary";
			}else if($row3['isHomeWinner']){
				$result="Home";
				$class="text-success";
			}else if($row3['isAwayWinner']){
				$result="Away";
				$class="text-info";
			}
		}else{
			$result="Not declared";
			$class="text-dark";
		}
		$data=array();
		$data['homeTeam']=$row3['homeTeam'];
		$data['awayTeam']=$row3['awayTeam'];
		$data['homeScore']=$row3['homeScore'];
		$data['awayScore']=$row3['awayScore'];
		$data['result']=$result;
		array_push($response['matchesList'],$data);
	}
}else{
	$response['success'] =0;
	$response["message"] = "Something went wrong.".$stmt3->error();  
} 				
				
$sql = "SELECT a.id,a.name,b.id as couponId,b.under2,b.under3,b.under4,b.under5,
		b.under6,b.under7,b.under8 FROM coupontypemaster a
		LEFT JOIN coupons b ON b.typeId=a.id
		WHERE b.week=$week AND b.status='A'";
$result = $connection->query($sql);
if ( $result ){
	while( $row = $stmt->fetch_assoc()){
		$coupon=array();
		$coupon['name']=$row['name'];
		$couponTypeId=$row['id'];
		$couponId=$row['couponId'];
		/*$coupon['under2']=$row['under2'];
		$coupon['under3']=$row['under3'];
		$coupon['under4']=$row['under4'];
		$coupon['under5']=$row['under5'];
		$coupon['under6']=$row['under6'];
		$coupon['under7']=$row['under7'];
		$coupon['under8']=$row['under8'];*/

		$sql="SELECT COUNT(id) as count FROM matches";
		$suffix=" Draws";
		$winnerType;
		switch($couponTypeId){
			case 1: $sql=$sql." WHERE isResultDeclared=1 AND ((isHomeWinner=1 AND isAwayWinner=1) OR (isHomeWinner=0 AND isAwayWinner=0)) AND week=$week"; $suffix=" Draws"; $winnerType=0; break;
			case 2: $sql=$sql." WHERE isResultDeclared=1 AND isHomeWinner=1 AND isAwayWinner=0 AND week=$week"; $suffix=" Homes"; $winnerType=1; break;
			case 3: $sql=$sql." WHERE isResultDeclared=1 AND isHomeWinner=0 AND isAwayWinner=1 AND week=$week"; $suffix=" Aways"; $winnerType=2; break;
			case 4: $sql=$sql." WHERE isResultDeclared=1 AND ((isHomeWinner=1 AND isAwayWinner=1) OR (isHomeWinner=0 AND isAwayWinner=0)) AND week=$week"; $suffix=" General Draws"; $winnerType=0; break;
			case 5: $sql=$sql." WHERE isResultDeclared=1 AND isHomeWinner=1 AND isAwayWinner=1 AND week=$week"; $suffix=" Score Draws"; $winnerType=0; break;
			case 6: case 7: case 8: case 9: case 10:
				$sql=$sql." WHERE isResultDeclared=1 AND ((isHomeWinner=1 AND isAwayWinner=1) OR (isHomeWinner=0 AND isAwayWinner=0)) AND week=$week"; $suffix=" Draws"; $winnerType=0; break;
		}
		$result2 = $connection->query($sql);
		$row2 = $result2->fetch_assoc();
		$draws=$row2['count'];
		
		$coupon['draws']=$draws;
		$coupon['suffix']=$suffix;
		
		//getting draw range for coupon
		$sql="SELECT * FROM couponodds WHERE couponId=$couponId";
		$result2 = $connection->query($sql);
		$row2 = $result2->fetch_assoc();
		$dFrom=$row2['dFrom'];
		$dTo=$row2['dTo'];
		
		$coupon['dFrom']=$row2['dFrom'];
		$coupon['dTo']=$row2['dTo'];
		
		$winnerU2=0;$winnerU3=0;$winnerU4=0;$winnerU5=0;$winnerU6=0;$winnerU7=0;$winnerU8=0;
		
		$sql="SELECT * FROM stacks WHERE couponId=$couponId";
		$result3 = $connection->query($sql);
		if($result3){
			while( $result3 = $stmt->fetch_assoc()){
				$sql="SELECT COUNT(id) as winnerTeamCount FROM stackdetail WHERE parentId=".$row3['id']." AND winner=$winnerType";
				$result4 = $connection->query($sql);
				$row4 = $result4->fetch_assoc();
				$winnerTeamCount=$row4['winnerTeamCount'];
				if($row['under2'] && $winnerTeamCount>=2){
					$winnerU2++;
				}
				if($row['under3'] && $winnerTeamCount>=3){
					$winnerU3++;
				}
				if($row['under4'] && $winnerTeamCount>=4){
					$winnerU4++;
				}
				if($row['under5'] && $winnerTeamCount>=5){
					$winnerU5++;
				}
				if($row['under6'] && $winnerTeamCount>=6){
					$winnerU6++;
				}
				if($row['under7'] && $winnerTeamCount>=7){
					$winnerU7++;
				}
				if($row['under8'] && $winnerTeamCount>=8){
					$winnerU8++;
				}
			}
		}
		$coupon['unders']=array();
		if($row['under2']==1){
			$dataU=array();
			$dataU['under']=2;
			$dataU['winners']=$winnerU2;
			array_push($coupon['unders'],$dataU);
		}
		if($row['under3']==1){
			$dataU=array();
			$dataU['under']=3;
			$dataU['winners']=$winnerU3;
			array_push($coupon['unders'],$dataU);
		}
		if($row['under4']==1){
			$dataU=array();
			$dataU['under']=4;
			$dataU['winners']=$winnerU4;
			array_push($coupon['unders'],$dataU);
		}
		if($row['under5']==1){
			$dataU=array();
			$dataU['under']=5;
			$dataU['winners']=$winnerU5;
			array_push($coupon['unders'],$dataU);
		}
		if($row['under6']==1){
			$dataU=array();
			$dataU['under']=6;
			$dataU['winners']=$winnerU6;
			array_push($coupon['unders'],$dataU);
		}
		if($row['under7']==1){
			$dataU=array();
			$dataU['under']=7;
			$dataU['winners']=$winnerU7;
			array_push($coupon['unders'],$dataU);
		}
		if($row['under8']==1){
			$dataU=array();
			$dataU['under']=8;
			$dataU['winners']=$winnerU8;
			array_push($coupon['unders'],$dataU);
		}
		/*$coupon['winnerU2']=$winnerU2;
		$coupon['winnerU3']=$winnerU3;
		$coupon['winnerU4']=$winnerU4;
		$coupon['winnerU5']=$winnerU5;
		$coupon['winnerU6']=$winnerU6;
		$coupon['winnerU7']=$winnerU7;
		$coupon['winnerU8']=$winnerU8;*/
			
		array_push($response['couponsList'],$coupon);
	}
	$response['success'] =1;
	$response["message"] = "Data list loading successful.";		
}else{
	$response['success'] =0;
	$response["message"] = "Something went wrong.".$result->error();  
} 
	
echo json_encode($response);			
?>