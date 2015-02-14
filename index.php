<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>EBA Textual View</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/jumbotron-narrow.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/main.css" rel="stylesheet">

  </head>

  <body>

    <div class="container">
      <div class="header">
        <h3 class="text-muted">Emma B. Andrews Diary Project</h3>
      </div>

      <div class="jumbotron">
        <h1>EBA Textual View</h1>
        <p class="lead">This view of the diary is generated using the PHP Expat event based parser. The outputted HTML is then styled using the Bootstrap CSS library.</p>
      </div>

      <div class="row marketing">
        <div class="col-lg-12">

        	<div id="tei_file">
				<?php
					
					// Initialize the XML parser
					$parser=xml_parser_create();

					// Function to use at the start of an element
					function start($parser,$element_name,$element_attrs) {
					  switch($element_name) {
						case "P":
							echo "<p class='tei_p'>";
							break;
						case "TEIHEADER":
							echo "<div id='tei_header'>";
							break;
						case "LB":
							echo "<br />";
							break;
						case "TITLE":
							echo "<h4 class='tei_title'>";
							break;
						case "PERSNAME":
							echo "<a tabindex='0' data-placement='auto top' data-toggle='popover' data-trigger='focus' data-container='body' title='Person Name' data-content='In future iterations of this viewer, the content in this popover will be dynamically generated from our Emmapedia resource.'>";
							break;
						case "PB":
							echo "<p class='tei_pb'>--- Page break in the original document : See  <a href='../../eba_diary_content/eba_volume_19/" .  $element_attrs[N] . ".jpg'>original scan</a>";
							break;
						default:
						  
					  };
					};

					// Function to use at the end of an element
					function stop($parser,$element_name) {
						switch($element_name) {
							case "P":
								echo "</p>";
								break;
							case "TEIHEADER":
								echo "</div>";
								break;
							case "TITLE":
								echo "</h4>";
								break;
							case "PERSNAME":
								echo "</a>";
								break;
							case "PB":
								echo " ---</p>";
								break;
							default:
						};
					};

					// Function to use when finding character data
					function char($parser,$data) {
						//echo utf8_decode($data);
						//echo iconv("UTF-8", "CP1252", $data);
						echo iconv("ISO-8859-1", "ISO-8859-1//TRANSLIT", $data);
					};

					// Specify element handler
					xml_set_element_handler($parser,"start","stop");

					// Specify data handler
					xml_set_character_data_handler($parser,"char");
					
						
						

					// Open XML file
					$fp=fopen('../../eba_diary_content/eba_volume_19/volume-19_1912-1913.xml',"r");

					// Read data
					while ($data=fread($fp,4096)) {
					  xml_parse($parser,$data,feof($fp)) or 
					  die (sprintf("XML Error: %s at line %d", 
					  xml_error_string(xml_get_error_code($parser)),
					  xml_get_current_line_number($parser)));
					};

					// Free the XML parser
					xml_parser_free($parser);
					
				?>
		</div>




        </div>

      </div>

      <footer class="footer">
        <p>Copyright &copy; 2014 Emma B. Andrews Diary Project. All Rights Reserved.</p>
      </footer>

    </div> <!-- /container -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>

    <script>
		$(function () {
	  		$('[data-toggle="popover"]').popover();
		})
	</script>  
  </body>
</html>
