
<style>
	.small-gap
	{
		margin-top:10px;
	}

</style>
<div class="main">
    <div class="main-inner">
        <div class="row-fluid show-grid">
            {if $themesdev.td_siderbar_without=="enable"}
                <div class="col-left sidebar span3">
                    {$HOOK_LEFT_COLUMN}
                    {$themesdev.td_left_sidebar_customhtml|html_entity_decode}

                </div>
            {/if}
			<div class="span9">
				<div class="small-gap"></div>
				<div class="row-fluid">
					<div class="span3">
						<span class="heading">Customer Name</span>
					</div>
					<div class="span3">
						{$customerName}
					</div>
					<div class="span3">
						<span class="heading">Customer Email</span>
					</div>
					<div class="span3">
						<span class="content">
							{$customerEmail}
						</span>
					</div>	
				
				</div>
				<div class="row-fluid">
					<div class="span3">
						<span class="heading">Date Of Birth/Establishment</span>
					</div>
					<div class="span3">
						{$dateOfBirth}
					</div>
					<div class="span3">
						<span class="heading">Contact Number</span>
					</div>
					<div class="span3">
						<span class="content">
							{$contactNumber}
						</span>
					</div>	
				
				</div>
				<div class="row-fluid">
					<div class="span3">
						<span class="heading">Address</span>
					</div>
					<div class="span9">
						{$customerAddress}
					</div>
						
				
				</div>
					
				<!-- Product Information -->
			
				<div class="row-fluid">
						<span style="text-align="center"><h4>Rental Info</h4></span>
					</div>
				<div class="row-fluid">
					<div class="span3">
						<span class="heading">Product Name</span>
					</div>
					<div class="span3">
						{$productName}
					</div>
					<div class="span3">
						<span class="heading">Product Amount</span>
					</div>
					<div class="span3">
						<span class="content">
							{displayPrice currency=1 price=$productAmount}
						</span>
					</div>	
				
				</div>
				<div class="row-fluid">
					<div class="span3">
						<span class="heading">Security Deposit</span>
					</div>
					<div class="span3">
						{displayPrice currency=1 price=$securityDeposit}
					</div>
					<div class="span3">
						<span class="heading">Monthly Rental</span>
					</div>
					<div class="span3">
						<span class="content">
							{displayPrice currency=1 price=$monthlyInstallment}
						</span>
					</div>	
				
				</div>
				<div class="row-fluid">
					<div class="span3">
						<span class="heading">Rental Duration</span>
					</div>
					<div class="span3">
						{$rentalDuration}&nbsp;Months
					</div>
					<div class="span3">
						<span class="heading">Current Status</span>
					</div>
					<div class="span3">
						{$statusName}&nbsp;
						
					</div>
					
				</div>
				<div class="row-fluid" {if $status lt 7} style='display:none;' {/if}>
					<div class="span3">
						<span class="heading">Activation Date</span>
					</div>
					<div class="span3">
						{$activationDate}
					</div>
					<div class="span3">
						<span class="heading">Monthly Expiration</span>
					</div>
					<div class="span3">
						{$monthly_expiration}&nbsp;
						
					</div>
					
				</div>
				
				<div class="row-fluid" {if $extension==0}style="display:none;"{/if}>
				<div class="row-fluid">
					<label><h3>Period Extended</h3></label>
				</div>
				<div class="row-fluid">
					<table width="100%">
							<tr>
								<th>Previous Duration</th>
								<th>Extended(Y/N)</th>
								<th>Extended Duration</th>
								<th>Monthly Rental</th>
								<th>Extending Date</th>
							</tr>
							{foreach from=$extensions key=stores item=data}
								<tr>
									<td>{$data['rent_duration']}&nbsp;Months</td>
									<td>{if $data['extend_period']==1}{l s='Accepted'}{/if}</td>
									<td>{$data['extend_duration']}&nbsp;Months</td>
									<td>{displayPrice currency=1 price=$data['extended_rental']}</td>
									<td>{$data['datetime']}</td>
								</tr>
							{/foreach}
					</table>
				</div>
				</div>
			<!-- payment tabs -->
			
			<div class="row-fluid" {if $payments==0}style="display:none;"{/if}>
				<div class="row-fluid">
					<label><h3>Payment Infomation</h3></label>
				</div>
				<div class="row-fluid">
					<table width="100%">
						<tr>
							<th>Serial Number</th>
							<th>Amount Received</th>
							<th>Bank Name</th>
							<th>Document Number/TID</th>
							<th>Payment Mode</th>
							<th>Payment Date</th>
						</tr>
						{assign var='sno' value=1}
						{foreach from=$loanData key=stores item=data}
							
							<tr >
								<td>{$sno}</td>
								<td>{displayPrice currency=1 price=$data['payment_received']}</td>
								<td>{$data['bank_name']}</td>
								<td>{$data['document_number']}</td>
								<td>{if $data['payment_mode']==0}{l s='By Cheque'}{/if}{if $data['payment_mode']==1}{l s='By Bank Transfer/Card'}{/if}</td>
								<td>{$data['DateTime']}</td>
							</tr>
							{assign var='sno' value=$sno+1}
						{/foreach}
					</table>
					
				</div>
				</div>
			</div>
                    </div>
		</div>
	</div>
	<style>
	table tr 
		{
			line-height:2.5em;
		}
	table tr td{
		text-align:center;
		font-weight:600;
	}
	table tr th
	{
		text-align:Center;
	}
	</style>