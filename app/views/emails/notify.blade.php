<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>D3 Catalyst Mail Sys.</title>
<meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
<style type="text/css">
* {margin:0;padding:0;font-family:verdana,helvetica,arial,sans-serif;font-size:13px;}
body,table,tbody,thead,tr,td {margin:0;padding:0;border-collapse:collapse}
table tr td {border: none;}
</style>
</head>
<body>
<table border="0" width="100%" height="auto" margin="0" padding="0">
	<tbody>
		<tr>
			<td align="center">
				<table border="0" bgcolor="#96067C" width="446" height="auto" margin="0" padding="0">
					<tbody>
						<tr height="112"><td align="center"><img width="228" height="112" alt="Bendita Tentacion" src="http://www.benditatentacion.com/img/LOGO.png"></td></tr>
						<tr bgcolor="#570047" align="center" height="20" style="color:white;">
							<td>
								<a style="text-decoration:none;color:white;font-weight: bold;" title="Lenceria" href="http://www.benditatentacion.com/catalogo/lenceria/">Lenceria</a> |
								<a style="text-decoration:none;color:white;font-weight: bold;" title="Zapatos" href="http://www.benditatentacion.com/catalogo/zapatos/">Zapatos</a> |
								<a style="text-decoration:none;color:white;font-weight: bold;" title="Juguetes" href="http://www.benditatentacion.com/catalogo/jueguetes/">Juguetes</a> |
								<a style="text-decoration:none;color:white;font-weight: bold;" title="Accesorios" href="http://www.benditatentacion.com/catalogo/accesorios/">Accesorios</a>
							</td>
						</tr>
						<tr bgcolor="#F0F0F0" height="auto">
							<td>
								<table>
									<tbody>
										<tr height="25">
											<td align="center" width="446" style="font-size:11px;border-bottom:1px solid #F700CA;">{{ $customer_name }}, tu orden #{{ $order_id }} a sido actualizada.</td>
										</tr>
										<tr width="426">
											<td align="center" style="padding:10px">
												<table width="100%">
													<tbody><tr>
														<td width="120" height="20" style="font-size:11px;border-bottom:1px solid #F700CA;font-weight: bold;">Numero de orden</td>
														<td align="center">{{ $order_id }}</td>
													</tr>
													<tr>
														<td width="120" height="20" style="font-size:11px;border-bottom:1px solid #F700CA;font-weight: bold;">Estatus</td>
														<td align="center">{{ $status }}</td>
													</tr>
													<tr>
														<td width="120" height="20" style="font-size:11px;border-bottom:1px solid #F700CA;font-weight: bold;">Paqueteria</td>
														<td align="center"><span style="text-decoration:none;color:black;font-weight: bold;">{{ $parcel }}</span></td>
													</tr>
													<tr>
														<td width="120" height="20" style="font-size:11px;border-bottom:1px solid #F700CA;font-weight: bold;">Guia</td>
														<td align="center">{{ $guide }}</td>
													</tr>
													<tr>
														<td width="120" height="20" style="font-size:11px;border-bottom:1px solid #F700CA;font-weight: bold;">Costo de envio</td>
														<td align="center">{{ $shipping_cost }}</td>
													</tr>
													<tr>
														<td width="120" height="20" style="font-size:11px;border-bottom:1px solid #F700CA;font-weight: bold;">Sub-Total de pedido</td>
														<td align="center">{{ $sub_total }}</td>
													</tr>
													<tr>
														<td width="120" height="20" style="font-size:11px;border-bottom:1px solid #F700CA;font-weight: bold;">Total</td>
														<td align="center" style="color:red;font-weight: bold;">{{ $total }}</td>
													</tr>
													<tr>
														<td width="120" height="auto" style="font-size:11px;border-bottom:1px solid #F700CA;font-weight: bold;">Nota</td>
														<td align="center">{{ $note }}</td>
													</tr>
												</tbody></table>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr align="center" height="20" style="color:white;"><td><a title="http://www.benditatentacion.com" style="text-decoration:none;color:white;" href="http://www.benditatentacion.com">Bendita Tentacion</a></td></tr>
						<tr bgcolor="#570047" align="center" height="40" style="color:white;">
							<td>
								<table>
									<tbody><tr>
										<td align="center" width="100"><a title="Facebook" href="https://www.facebook.com/benditatentaciongdl"><img alt="Facebook" src="http://www.benditatentacion.com/img/social/fb.png"></a></td>
										<td align="center" width="100"><a title="Twitter" href="https://twitter.com/benditatentacio"><img alt="Twitter" src="http://www.benditatentacion.com/img/social/tt.png"></a></td>
										<td align="center" width="100"><a title="Google+" href="https://plus.google.com/+Benditatentacion"><img alt="Google+" src="http://www.benditatentacion.com/img/social/gg.png"></a></td>
									</tr>
								</tbody></table>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>
</body>
</html>