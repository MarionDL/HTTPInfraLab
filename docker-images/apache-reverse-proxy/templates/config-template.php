<?php 
    $static_app1 = getenv('STATIC_APP1');
    $dynamic_app1 = getenv('DYNAMIC_APP1');
	
	$static_app2 = getenv('STATIC_APP2');
    $dynamic_app2 = getenv('DYNAMIC_APP2');
?>

<VirtualHost *:80>

	ServerName demo.res.ch

    # to implement the stickysession we set up a cookie based system that will guarantee that a session will always be threated
	# from the same app
    # inspired from http://docs.motechproject.org/en/latest/deployment/sticky_session_apache.html (method 2)
    Header add Set-Cookie "ROUTEID=.%{BALANCER_WORKER_ROUTE}e; path=/" env=BALANCER_ROUTE_CHANGED
    
	<Proxy balancer://static-cluster>
	
		BalancerMember http://<?php print "$static_app1"?> route=static1
		BalancerMember http://<?php print "$static_app2"?> route=static2
		
		ProxySet lbmethod=byrequests
		# handle stickysessions
		ProxySet stickysession=ROUTEID

	</Proxy>
	
	<Proxy balancer://dynamic-cluster>

		BalancerMember http://<?php print "$dynamic_app1"?> route=dynamic1
		BalancerMember http://<?php print "$dynamic_app2"?> route=dynamic2
		
		# round robin for the dynamic server nodes
		# inspired by https://support.rackspace.com/how-to/simple-load-balancing-with-apache/
		ProxySet lbmethod=byrequests
		ProxySet stickysession=ROUTEID

	</Proxy>
	
	ProxyPreserveHost On
	
	ProxyPass '/api/bubu/' balancer://dynamic-cluster/
	ProxyPassReverse '/api/bubu/' balancer://dynamic-cluster/
	
	ProxyPass '/' balancer://static-cluster/
	ProxyPassReverse '/' balancer://static-cluster/
	

</VirtualHost>