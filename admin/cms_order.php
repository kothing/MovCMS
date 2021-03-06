<?php
include('../system/inc.php');
include('cms_check.php');
error_reporting(0);
include('model/order.php');
?>
<?php include('inc_header.php') ?>
<script type="text/javascript">
	$(function() {
		//操作执行验证
		$('#execute').click(function() {
			if ($('#execute_method').val() == '') {
				alert('请选择一项要执行的操作！');
				return false;
			};
			if ($('input[name="id[]"]').val() = '') {
				alert('请至少选择一项！');
				return false;
			};
		});
		//频道转移验证
		$('#shift').click(function() {
			if ($('#shift_target').val() == '') {
				alert('请选择要转移到的频道！');
				return false;
			};
			if ($('input[name="id[]"]').val() = '') {
				alert('请至少选择一项！');
				return false;
			};
		});
		//搜索验证
		$('#search').click(function() {
			if ($('#key').val() == '') {
				alert('请输入要查找的关键字');
				$('#key').focus();
				return false;
			};
		});
	});

	function check_all(cname) {
		$('input[name="' + cname + '"]:checkbox').each(function() {
			this.checked = !this.checked;
		});
	}
</script>
<!-- Start: Content -->
<div class="container-fluid content">
	<div class="row">
		<?php include('inc_left.php') ?>
		<!-- Main Page -->
		<div class="main ">
			<!-- Page Header -->
			<div class="page-header">
				<div class="pull-left">
					<ol class="breadcrumb visible-sm visible-md visible-lg">
						<li><a href="cms_welcome.php"><i class="icon fa fa-home"></i>首页</a></li>
					</ol>
				</div>
				<div class="pull-right">
					<h2>订单管理</h2>
				</div>
			</div>
			<!-- End Page Header -->


			<div class="row">
				<div class="col-lg-12">
					<div class="panel">
						<div class="panel-heading bk-bg-primary">
							<h6><i class="fa fa-table red"></i><span class="break"></span>订单管理</h6>

						</div>
						<div class="panel-body">
							<div class="table-responsive">

								<form method="post" class="form-auto">
									<table class="table table-striped table-bordered bootstrap-datatable datatable">
										<thead>
											<tr>
												<th width="40" align="center">选择</th>
												<th width="40" align="center">ID</th>
												<th>订单编号</th>
												<th>会员</th>
												<th>金额</th>
												<th>时间</th>
												<th>状态</th>
												<th>会员套餐</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$sql = 'select * from mkcms_user_pay order by p_id desc';
											$pager = page_handle('page', 10, mysqli_num_rows(mysqli_query($conn, $sql)));
											$result = mysqli_query($conn, $sql . ' limit ' . $pager[0] . ',' . $pager[1] . '');

											while ($row = mysqli_fetch_array($result)) {
											?>
												<tr>
													<td>
														<div class="checkbox-custom checkbox-default">
															<input type="checkbox" name="id[]" value="<?php echo $row['p_id'] ?>" />
															<label for="checkboxExample2"></label>
														</div>
													</td>
													<td><?php echo $row['p_id'] ?></td>
													<td><?php echo $row['p_order'] ?></td>
													<td><?php echo $row['p_uid'] ?></td>
													<td><?php echo $row['p_price'] ?></td>
													<td><?php echo $row['p_time'] ?></td>
													<td>
														<?php
														echo ($row['p_status'] == 1 ? '<span class="label label-warning">成功</span> ' : '');
														echo ($row['p_status'] == 0 ? '<span class="label label-danger">失败</span> ' : '');
														?></td>
													<td><?php
														$result2 = mysqli_query($conn, 'select * from mkcms_user_group where ug_id=' . $row['p_group'] . '');
														while ($row2 = mysqli_fetch_array($result2)) {
															echo $row2['ug_name'];
														}
														?></td>
												</tr>
											<?php } ?>
											<tr>
												<td><span class="bk-margin-5 btn btn-primary" onclick="check_all('id[]')">选</span></td>
												<td colspan="2">
													<select id="execute_method" class="btn btn-default" name="execute_method">
														<option value="">请选择操作</option>
														<option value="delete">删除选中</option>
													</select>
													<input type="submit" id="execute" class="bk-margin-5 btn btn-primary" name="execute" onclick="return confirm('确定要执行吗')" value="执行" />
												</td>
												<td colspan="6">
												</td>
											</tr>
										</tbody>
									</table>
								</form>
								<div class="page_show"><?php echo page_show($pager[2], $pager[3], $pager[4], 2); ?> </div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
		<!-- End Main Page -->

		<?php include('inc_footer.php') ?>