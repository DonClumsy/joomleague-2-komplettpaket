<?php defined('_JEXEC') or die('Restricted access');
?>		


			<fieldset class="adminform">
				<legend>
					<?php
					echo JText::_('COM_JOOMLEAGUE_ADMIN_PERSON_ASSIGN_DESCR');
					?>
				</legend>
				<table class="admintable" border="0">
					<tr>
						<td class="key">
							<label for="project_id">
								<?php
								echo JText::_('COM_JOOMLEAGUE_ADMIN_PERSON_ASSIGN_PID');
								?>
							</label>
						</td>
						<td>
							<input	class="text_area" type="text" name="project_id" id="project_id" value=""
									size="4" maxlength="5" />
						</td>
						<td colspan="2" rowspan="2">
							<div class="button2-left" style="display:inline">
								<div class="readmore">
									<?php
									//create the button code to use in form while selecting a project and team to assign a new person to
									$button = '<a class="modal-button" title="Select" ';
									$button .= 'href="index.php?option=com_joomleague&view=person&task=person.personassign" ';
									$button .= 'rel="{handler: \'iframe\', size: {x: 600, y: 400}}">' . JText::_('Select') . '</a>';
									#echo $this->button;
									echo $button;
									?>
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="team">
								<?php
								echo JText::_('COM_JOOMLEAGUE_ADMIN_PERSON_ASSIGN_TID');
								?>
							</label>
						</td>
						<td>
							<input	class="text_area" type="text" name="team_id" id="team_id" value="" size="4"
									maxlength="5" />
						</td>
					</tr>
				</table>
			</fieldset>