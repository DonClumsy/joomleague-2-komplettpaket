<?php defined('_JEXEC') or die('Restricted access');
?>
<br />
<form method="post" name="matrixForm" id="matrixForm">

<fieldset class="adminform"><legend><?php echo JText::sprintf('JL_ADMIN_SINGLE_MATCHES_TITLE','<i>'.$this->roundws->name.'</i>','<i>'.$this->projectws->name.'</i>'); ?></legend>
<fieldset class="adminform">
	<?php echo JText::_('JL_ADMIN_SINGLE_MATCHES_MATRIX_HINT'); ?>
</fieldset>
<?php

$model =& $this->getModel();
$teams= $model->getProjectTeams();

$homeplayer = $model->getHomePlayer();
$awayplayer = $model->getAwayPlayer();

// echo 'homeplayer<br><pre>';
// print_r($homeplayer);
// echo '</pre>';

// echo 'awayplayer<br><pre>';
// print_r($awayplayer);
// echo '</pre>';

// echo 'matches<br><pre>';
// print_r($this->matches);
// echo '</pre>';

$matrix ='';

if (count($homeplayer) <= 20  && $homeplayer ) {
	$matrix = "<table width=\"100%\" class=\"adminlist\">";

	$k = 0;
	for($rows = 0; $rows <= count($homeplayer); $rows++){
		if($rows == 0) $trow = $homeplayer[0];
		else $trow = $homeplayer[$rows-1];
		$matrix .= "<tr class=\"row$k\">";
		for($cols = 0; $cols <= count($awayplayer); $cols++){
			$text = '';
			$checked = '';
			$color = 'white';
			if( $cols == 0 ) $tcol = $awayplayer[0];
			else $tcol = $awayplayer[$cols-1];
			$match = $trow->value.'_'.$tcol->value;
			$onClick = sprintf("onClick=\"javascript:SaveMatch('%s','%s');\"", $trow->value, $tcol->value);
			if($rows == 0 && $cols == 0) $text = "<th align=\"center\"></th>";
			else if($rows == 0) $text = sprintf("<th width=\"200\" align=\"center\" title=\"%s\">%s</th>",$tcol->text,$tcol->text); //picture columns
			else if($cols == 0) $text = sprintf("<td align=\"left\" nowrap>%s</td>",$trow->text); // named rows
			//else if($rows == $cols) $text = "<td align=\"center\"><input type=\"radio\" DISABLED></td>"; //impossible matches

			else{
				if(count($this->matches) >0) {
					for ($i=0,$n=count($this->matches); $i < $n; $i++)
					{
						$row =& $this->matches[$i];
						if($row->teamplayer1_id == $trow->value 
							&& $row->teamplayer2_id == $tcol->value
						){
							$checked = 'checked';
							$color = 'teal';
							$onClick = '';
							break;
						} else {
							$checked = '';
							$color = 'white';
							$onClick = sprintf("onClick=\"javascript:SaveMatch('%s','%s');\"", $trow->value, $tcol->value);
						}
					}
				}	
				$text = sprintf("<td align=\"center\" title=\"%s - %s\" bgcolor=\"%s\"><input type=\"radio\" name=\"match_%s\" %s %s></td>\n",$trow->text,$tcol->text,$color,$trow->value.$tcol->value, $onClick, $checked);
			}
			$matrix .= $text;
		}
		$k = 1 - $k;
	}
	$matrix .= "</table>";
}
//show the matrix
echo $matrix;
?></fieldset>
<?php $dValue=$this->roundws->round_date_first.' '.$this->projectws->start_time; ?>
<input type='hidden' name='match_date' value='<?php echo $dValue; ?>' />
<input type='hidden' name='controller' value='jlextindividualsport' />
<input type='hidden' name='projectteam1_id' value='<?php echo $this->projectws->projectteam1_id; ?>' />
<input type='hidden' name='projectteam2_id' value='<?php echo $this->projectws->projectteam2_id; ?>' />

<input type='hidden' name='teamplayer1_id' value='' />
<input type='hidden' name='teamplayer2_id' value='' />

<input type='hidden' name='published' value='1' />
<input type='hidden' name='task' value='addmatch' />
<?php echo JHTML::_('form.token')."\n"; ?>
</form>
