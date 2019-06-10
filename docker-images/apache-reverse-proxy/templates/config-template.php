<?php 
    $static_app1 = getenv('STATIC_APP1');
    $dynamic_app1 = getenv('DYNAMIC_APP1');
	
	$static_app2 = getenv('STATIC_APP2');
    $dynamic_app2 = getenv('DYNAMIC_APP2');
?>

<VirtualHost *:80>

    ServerName demo.res.ch
	
	<Proxy balancer://static-cluster>
	
		BalancerMember 'http://<?php print "$static_app1"?>'
		BalancerMember 'http://<?php print "$static_app2"?>'

	</Proxy>
	
	<Proxy balancer://dynamic-cluster>

		BalancerMember 'http://<?php print "$dynamic_app1"?>'
		BalancerMember 'http://<?php print "$dynamic_app2"?>'

	</Proxy>
	
	ProxyPreserveHost On
	
	ProxyPass '/api/bubu/' balancer://dynamic-cluster/
	ProxyPassReverse '/api/bubu/' balancer://dynamic-cluster/
	
	ProxyPass '/' balancer://static-cluster/
	ProxyPassReverse '/' balancer://static-cluster/
	

</VirtualHost>