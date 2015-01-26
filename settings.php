		    <table class="form-table">
		        <tr valign="top">
		        <th scope="row"><strong><?php _e('Experiment 1:', 'ui-labs' ); ?></strong> <?php _e('Colour-Coded Post Statuses', 'ui-labs' ); ?></th>
		        <td><input type="checkbox" name="poststatuses" value="yes"<?php echo $this->options['poststatuses'] == 'yes' ? ' checked' : '';?> /></td>
		        </tr>
		         
		        <tr valign="top">
		        <th scope="row"><strong><?php _e('Experiment 2:', 'ui-labs' ); ?></strong> <?php _e('Classic WordPress Admin Bar', 'ui-labs' ); ?></th>
		        <td><input type="checkbox" name="adminbar" value="yes"<?php echo $this->options['adminbar'] == 'yes' ? ' checked' : '';?> /></td>
		        </tr>
		        
		        <tr valign="top">
		        <th scope="row"><strong><?php _e('Experiment 3:', 'ui-labs' ); ?></strong> <?php _e('Identify This Server', 'ui-labs' ); ?></th>
		        <td><input type="checkbox" name="identify" value="yes"<?php echo $this->options['identify'] == 'yes' ? ' checked' : '';?> /></td>
		        </tr>
		        <tr valign="top">
		        <th scope="row"><?php _e('Server type', 'ui-labs' ); ?></th>
		        <td>
		        	<select id="servertype" name="servertype">
		        		<option value="uilabs-blank"<?php echo $this->options['servertype'] == 'uilabs-blank' ? ' selected' : '';?>> -- </option>
		        		<option value="uilabs-development"<?php echo $this->options['servertype'] == 'uilabs-development' ? ' selected' : '';?>><?php _e('Development', 'ui-labs' ); ?></option>
		        		<option value="uilabs-staging"<?php echo $this->options['servertype'] == 'uilabs-staging' ? ' selected' : '';?>><?php _e('Staging', 'ui-labs' ); ?></option>
		        		<option value="uilabs-live"<?php echo $this->options['servertype'] == 'uilabs-live' ? ' selected' : '';?>><?php _e('Live', 'ui-labs' ); ?></option>
		        	</select>
		        </td>
		        </tr>
		    </table>
