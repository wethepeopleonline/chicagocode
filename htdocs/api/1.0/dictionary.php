<?php

header("HTTP/1.0 200 OK");
header('Content-type: application/json');

/*
 * If we have received neither a term nor a section, we can't do anything.
 */
if ( empty($_GET['term']) && empty($_GET['section']) )
{
	json_error('Neither a dictionary term nor a section number have been provided.');
	die();
}

$api = new API;
$api->list_all_keys();

/*
 * Make sure that the key is the correct (safe) length.
 */
if ( strlen($_GET['key']) != 16 )
{
	json_error('Invalid API key.');
	die();
}

/*
 * Localize the key, filtering out unsafe characters.
 */
$key = filter_input(INPUT_GET, 'key', FILTER_SANITIZE_STRING);

/*
 * If no key has been passed with this query, or if there are no registered API keys.
 */
if ( empty($key) || (count($api->all_keys) == 0) )
{
	json_error('API key not provided. Please register for an API key.');
	die();
}
elseif (!isset($api->all_keys->$key))
{
	json_error('Invalid API key.');
	die();
}

/*
 * Use a provided JSONP callback, if it's safe.
 */
if (isset($_REQUEST['callback']))
{
	$callback = $_REQUEST['callback'];

	/*
	 * If this callback contains any reserved terms that raise XSS concerns, refuse to proceed.
	 */
	if (valid_jsonp_callback($callback) === FALSE)
	{
		json_error('The provided JSONP callback uses a reserved word.');
		die();
	}
}

/*
 * If a section has been specified, then clean that up.
 */
if (isset($_GET['section']))
{
	$section = filter_input(INPUT_GET, 'section', FILTER_SANITIZE_STRING);
}

/*
 * Create a new instance of the dictionary class.
 */
$dict = new Dictionary();

/*
 * If a term has been provided, then retrieve its definition.
 */
if (!empty($_GET['term']))
{

	# Clean up the term.
	$term = filter_input(INPUT_GET, 'term', FILTER_SANITIZE_STRING);

	if (isset($section))
	{
		$dict->section_number = $section;
	}
	$dict->term = $term;
	$dictionary = $dict->define_term();
	
	# If, for whatever reason, this word is not found, return an error.
	if ($dictionary === false)
	{
		$response = array('definition' => 'Definition not available.');
	}
	
	else
	{
	
		# Uppercase the first letter of the first (quoted) word. We perform this twice because some
		# legal codes begin the definition with a quotation mark and some do not. (That is, some write
		# '"Whale" is a large sea-going mammal' and some write 'Whale is a large sea-going mammal.")
		if (preg_match('/[A-Za-z]/', $dictionary->definition[0]) === 1)
		{
			$dictionary->definition[0] = strtoupper($dictionary->definition[0]);
		}
		elseif (preg_match('/[A-Za-z]/', $dictionary->definition[1]) === 1)
		{
			$dictionary->definition[1] = strtoupper($dictionary->definition[1]);
		}
	
		# If the request contains a specific list of fields to be returned.
		if (isset($_GET['fields']))
		{
			# Turn that list into an array.
			$returned_fields = explode(',', urldecode($_GET['fields']));
			foreach ($returned_fields as &$field)
			{
				$field = trim($field);
			}
			
			# It's essential to unset $field at the conclusion of the prior loop.
			unset($field);
			
			foreach ($dictionary as &$term)
			{
				# Step through our response fields and eliminate those that aren't in the requested
				# list.
				foreach($term as $field => &$value)
				{
					if (in_array($field, $returned_fields) === false)
					{
						unset($term->$field);
					}
				}
			}
		}
	
		# If a section has been specified, then simplify this response by returning just a single
		# definition.
		if (isset($section))
		{
			$dictionary = $dictionary->{0};
		}
		
		# Rename this variable to use the expected name.
		$response = $dictionary;
	}
}

# If a term hasn't been provided, then retrieve a term list for the specified section.
else
{
	
	# First, get the structural ID of the container for this section.
	$law = new Law;
	$law->section_number = $section;
	$law->config = FALSE;
	$result = $law->get_law();
	if ($result == FALSE)
	{
		$response = array('terms' => 'Term list not available.');
	}
	else
	{
		
		$dict->section_id = $law->section_id;
		$dict->structure_id = $law->structure_id;
		$response = $dict->term_list();
		if ($response == FALSE)
		{
			$response = array('terms' => 'Term list not available.');
		}
		
	}
	
}

# Include the API version in this response.
if(isset($args['api_version']) && strlen($args['api_version']))
{
	$response->api_version = filter_var($args['api_version'], FILTER_SANITIZE_STRING);
}
else
{
	$response->api_version = CURRENT_API_VERSION;
}

if (isset($callback))
{
	echo $callback.' (';
}
echo json_encode($response);
if (isset($callback))
{
	echo ');';
}
