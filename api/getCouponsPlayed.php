<?php
include ('../common/config.php');
include('../common/functions.php');
$response=array();
$response['couponsList']=array();
if(!empty($_POST['userId'])){
	$sql = "SELECT id, couponId,week,under2,under3,under4,under5,under6,under7,under8,stackAmount,
			(SELECT COUNT(id) FROM stackdetail WHERE parentId=s.id) as totalSelected FROM stacks s 
			WHERE userId=".$_POST['userId']." AND status='A' ORDER BY id DESC";
	$stmt3 = $connection->query($sql);
	// echo mysql_error();
	if ( $stmt3 ){
		while( $row3 = $stmt3->fetch_assoc()){
			$status="";
			$week=$row3['week'];
			$stackAmount=$row3['stackAmount'];
			$totalSelected=$row3['totalSelected'];
			$unders=($row3['under2'])?" 2 ":"";
			$unders=$unders.(($row3['under3'])?" 3 ":"");
			$unders=$unders.(($row3['under4'])?" 4 ":"");
			$unders=$unders.(($row3['under5'])?" 5 ":"");
			$unders=$unders.(($row3['under6'])?" 6 ":"");
			$unders=$unders.(($row3['under7'])?" 7 ":"");
			$unders=$unders.(($row3['under8'])?" 8 ":"");
			
			//to compare with native coupon
			$sql="SELECT id,typeId,(SELECT name FROM coupontypemaster WHERE id=typeId) as name,
					under2,under3,under4,under5,under6,under7,under8
					FROM coupons WHERE id=".$row3['couponId'];
			$result4 = $connection->query($sql);
			$row4 = $result4->fetch_assoc();
			
			//------------------
			$winnerType;
			$sql="SELECT COUNT(id) as count FROM matches";
			$suffix=" Draws";
			$winnerType;
			switch($row4['typeId']){
				//case 1: $sql=$sql." WHERE isResultDeclared=1 AND ((isHomeWinner=1 AND isAwayWinner=1) OR (isHomeWinner=0 AND isAwayWinner=0)) AND week=$week"; $suffix=" Draws"; $winnerType=0; break;
				case 2: $sql=$sql." WHERE isResultDeclared=1 AND isHomeWinner=1 AND isAwayWinner=0 AND week=$week"; $suffix=" Homes"; $winnerType=1; break;
				case 3: $sql=$sql." WHERE isResultDeclared=1 AND isHomeWinner=0 AND isAwayWinner=1 AND week=$week"; $suffix=" Aways"; $winnerType=2; break;
				//case 4: $sql=$sql." WHERE isResultDeclared=1 AND ((isHomeWinner=1 AND isAwayWinner=1) OR (isHomeWinner=0 AND isAwayWinner=0)) AND week=$week"; $suffix=" General Draws"; $winnerType=0; break;
				case 5: $sql=$sql." WHERE isResultDeclared=1 AND isHomeWinner=1 AND isAwayWinner=1 AND week=$week"; $suffix=" Score Draws"; $winnerType=0; break;
				case 1: case 4: case 6: case 7: case 8:
					$sql=$sql." WHERE isResultDeclared=1 AND ((isHomeWinner=1 AND isAwayWinner=1) OR (isHomeWinner=0 AND isAwayWinner=0)) AND week=$week"; $suffix=" Draws"; $winnerType=0; break;
			}
			if($row4['typeId']==4){
				$suffix=" General Draws";
			}
			$result6 = $connection->query($sql);
			$row6 = $result6->fetch_assoc();
			$draws=$row6['count'];
			
			//getting draw range for coupon
			$sql="SELECT * FROM couponodds WHERE $draws>=dFrom AND $draws<=dTo AND couponId=".$row3['couponId'];
			$result7 = $connection->query($sql);
			$row7 = $result7->fetch_assoc();
			$odds2=$row7['odds2'];$odds3=$row7['odds3'];$odds4=$row7['odds4'];$odds5=$row7['odds5'];$odds6=$row7['odds6'];$odds7=$row7['odds7'];$odds8=$row7['odds8'];
			//------------------

			$sql="SELECT COUNT(id) as winnerCount FROM stackdetail WHERE parentId=".$row3['id']." AND winner=$winnerType";
			$result5 = $connection->query($sql);
			$row5 = $result5->fetch_assoc();
			$winnerCount=$row5['winnerCount'];
			
			$totalLines=0;$winningLines=0;$winningAmount=0;
			if($row3['under2'] && $row4['under2']){
				$totalLines=$totalLines+getTotalLines($totalSelected,2);
			}
			if($row3['under3'] && $row4['under3']){
				$totalLines=$totalLines+getTotalLines($totalSelected,3);
			}
			if($row3['under4'] && $row4['under4']){
				$totalLines=$totalLines+getTotalLines($totalSelected,4);
			}
			if($row3['under5'] && $row4['under5']){
				$totalLines=$totalLines+getTotalLines($totalSelected,5);
			}
			if($row3['under6'] && $row4['under6']){
				$totalLines=$totalLines+getTotalLines($totalSelected,6);
			}
			if($row3['under7'] && $row4['under7']){
				$totalLines=$totalLines+getTotalLines($totalSelected,7);
			}
			if($row3['under8'] && $row4['under8']){
				$totalLines=$totalLines+getTotalLines($totalSelected,8);
			}
			//Stack per line
			$stackPerLine=$stackAmount/$totalLines;
			
			if($row3['under2'] && $row4['under2']){
				if($totalLines>0 && $winnerCount>=2){
					$winningLines=getWinningLines($winnerCount,2);
					$winningAmount=($winningLines*$stackPerLine*$odds2);
				}
			}
			if($row3['under3'] && $row4['under3']){
				if($totalLines>0 && $winnerCount>=3){
					$winningLines=getWinningLines($winnerCount,3);
					$winningAmount=$winningAmount+($winningLines*$stackPerLine*$odds3);
				}
			}
			if($row3['under4'] && $row4['under4']){
				if($totalLines>0 && $winnerCount>=4){
					$winningLines=getWinningLines($winnerCount,4);
					$winningAmount=$winningAmount+($winningLines*$stackPerLine*$odds4);
				}
			}
			if($row3['under5'] && $row4['under5']){
				if($totalLines>0 && $winnerCount>=5){
					$winningLines=getWinningLines($winnerCount,5);
					$winningAmount=$winningAmount+($winningLines*$stackPerLine*$odds5);
				}
			}
			if($row3['under6'] && $row4['under6']){
				if($totalLines>0 && $winnerCount>=6){
					$winningLines=getWinningLines($winnerCount,6);
					$winningAmount=$winningAmount+($winningLines*$stackPerLine*$odds6);
				}
			}
			if($row3['under7'] && $row4['under7']){
				if($totalLines>0 && $winnerCount>=7){
					$winningLines=getWinningLines($winnerCount,7);
					$winningAmount=$winningAmount+($winningLines*$stackPerLine*$odds7);
				}
			}
			if($row3['under8'] && $row4['under8']){
				if($totalLines>0 && $winnerCount>=8){
					$winningLines=getWinningLines($winnerCount,8);
					$winningAmount=$winningAmount+($winningLines*$stackPerLine*$odds8);
				}
			}
			if($winningAmount>0){
				$status="Won ".$winningAmount." ₦";
			}
			
			$data=array();
			$data['id']=$row3['id'];
			$data['name']=$row4['name'];
			$data['week']=$row3['week'];
			$data['unders']=$unders;
			$data['stackAmount']=explode(".",$row3['stackAmount'])[0]." ₦";
			$data['status']=$status;
			$data['draws']=$draws;
			
			array_push($response['couponsList'],$data);
		}
		$response['success'] =1;
		$response["message"] = "Data loaded.";
	}else{  
		$response['success'] =0;
		$response["message"] = "Something went wrong.".$stmt3->error();  
	} 
	}else{
		$response['success'] =0;
		$response["message"] = "Parameters missing!.";	
	}
		
	echo json_encode($response);			
?>