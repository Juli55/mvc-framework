{% extends 'project::.twig' %}
<html>
	<head>
		<title>{{ kk .hey.nummer4 }}</title>

	</head>
	<body>
		{% block content %}
			<h1>{{kk .hey.nummer4}}</h1>
		{% endblock %}
	</body>
	{% set variable = 1 %}
	{{ variable }}
</html>