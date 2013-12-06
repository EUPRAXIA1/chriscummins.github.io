<!--
    Copyright © 2013 Intel Corporation

    Permission is hereby granted, free of charge, to any person obtaining a copy
    of this software and associated documentation files (the "Software"), to
    deal in the Software without restriction, including without limitation the
    rights to use, copy, modify, merge, publish, distribute, sublicense, and/or
    sell copies of the Software, and to permit persons to whom the Software is
    furnished to do so, subject to the following conditions:

    The above copyright notice and this permission notice (including the next
    paragraph) shall be included in all copies or substantial portions of the
    Software.

    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
    IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.  IN NO EVENT SHALL THE
    AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
    LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
    FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
    IN THE SOFTWARE.

    Author:
      Chris Cummins <christopher.e.cummins@intel.com>
  -->

<!doctype html>

<html lang="en">
  <head>
    <title>Chris Cummins | GEN Regions Visualiser - Intel Graphics</title>
    <meta name="description" content="This web tool visualizes instruction source operand regions for the Intel Graphics GEN architecture.">
    <meta name="author" content="Chris Cummins">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="width=1024" />
    <meta charset="utf-8" />

    <style type="text/css">body{padding-top:60px;}</style>
    <link rel="stylesheet" href="/css/styles.css" />
    <link rel="shortcut icon" href="/img/favicon.ico" />

    <style>
      .alert {
        display: none;
      }

      .btn {
        display: inline;
        width: 110px;
      }

      #gen-frame td {
        padding-right: 15px;
      }

      .select.select-block .btn {
        margin-top: 10px;
      }

      .alert {
        font-size: 14px;
      }
    </style>
  </head>

  <body>

    <!-- Google Analytics -->
    <script type="text/javascript">
      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-40829804-1']);
      _gaq.push(['_trackPageview']);

      (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();
    </script>

    <div id="wrap">

      <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
          <div class="container">
            <button type="button" class="btn btn-navbar"
                    data-toggle="collapse" data-target=".nav-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="brand" href="http://chriscummins.cc">chriscummins.cc</a>
            <div class="nav-collapse collapse pull-right">
              <ul class="nav">
                <li><a href="/">Home</a></li>
                <li><a href="/blog/">Blog</a></li>
                <li><a href="/music/">Music</a></li>
                <li class="active"><a href="/software/">Software</a></li>
                <li><a href="/pictures/">Pictures</a></li>
              </ul>
            </div><!--/.nav-collapse -->
          </div>
        </div>
      </div> <!-- /.navbar -->

      <div class="container">

        <div class="fixed-container-narrow">

          <div class="headline">
            <h1 class="headline-title">
              GEN Regions
            </h1>
          </div>

          <div id="gen-frame" class="bordered-frame">
            <center>

              <!-- canvas -->
              <canvas id="canvas" width="728" height="250"
                      data-toggle="tooltip" title="No region set">
                Unsupported browser!</canvas>

              <!-- input -->
              <table style="padding: 5px; margin: 5px auto;">
                <tr>
                  <td>
                    <!-- exec size dropdown -->
                    <select id="exec-size" name="exec-size"
                            class="select-block"
                            value="8" data-width="80px"
                            data-toggle="tooltip" title="Execution Size">
                      <option>1</option>
                      <option>2</option>
                      <option>4</option>
                      <option selected="selected">8</option>
                      <option>16</option>
                      <option>32</option>
                    </select>
                  </td>
                  <td>
	            <!-- The region input text box: -->
                    <input id="region-form" class="search-query" type="text"
	                   placeholder="Region description" style="width: 250px;"
                           data-toggle="tooltip" title="Region description">
                  </td>
                  <td>
	            <!-- The `advanced' mode checkbox: -->
                    <div class="switch switch-square">
                      <input id="advanced" type="checkbox" checked="">
                    </div>
                  </td>
                  <td>
                    <!-- submit button -->
                    <button id="submit" class="btn btn-success">
                      Submit
                    </button>
                  </td>
                  <td>
	            <!-- share button -->
                    <button id="share-btn" class="btn btn-primary">
                      Share
                    </button>
                  </td>
                </tr>
              </table>

            </center>

            <!-- alerts area -->
            <div>
              <!-- share URL -->
              <div id="share" class="alert alert-success"><strong>URL</strong>
                <textarea id="share-hash" class="text"
                          style="width: 579px; height: 30px; resize: none; margin-bottom: 0px; margin-left: 10px;"
                          readonly></textarea>
                <button type="button" class="close">&times;</button></div>
              <!-- error -->
              <div id="alert-error" class="alert alert-error">
                <button type="button" class="close">&times;</button>
	        <div id="alert-error-placeholder"></div></div>
              <!-- warning -->
              <div id="alert" class="alert">
	        <button type="button" class="close">&times;</button>
	        <div id="alert-placeholder"></div></div>

            </div> <!-- /alerts area -->

          </div> <!-- /frame -->

          <!-- documentation -->
          <h3>Usage</h3>
          <ol class="muted">
            <li>Select an execution size from the dropdown box.</li>
            <li>Enter a register region description into the text area.</li>
            <li>Toggle the advanced mode switch to change SubRegNum from being
              in units of data type to byte offset.</li>
          </ol>

          <h3>Key Bindings</h3>
          <p class="muted">
            The following page-wide keybindings are defined for convenience:
            <br/><br/>
          </p>

          <center>
            <table class="muted">
              <tr><td style="text-align: right; padding-right: 10px;">
                  <code><strong>[return]</strong></code></td>
                <td>Submit region</td></tr>

              <tr><td style="text-align: right; padding-right: 10px;">
                  <code><strong>[escape]</strong></code></td>
                <td>Dismiss warnings</td></tr>

              <tr><td style="text-align: right; padding-right: 10px;">
                  <code><strong>a</strong></code></td>
                <td>Toggle --advanced</td></tr>

              <tr><td style="text-align: right; padding-right: 10px;">
                  <code><strong>r</strong></code></td>
                <td>Focus on region text box</td></tr>

              <tr><td style="text-align: right; padding-right: 10px;">
                  <code><strong>c</strong></code></td>
                <td>Clear region description</td></tr>

              <tr><td style="text-align: right; padding-right: 10px;">
                  <code><strong>s</strong></code></td>
                <td>Share</td></tr>
            </table>
          </center>

          <h3>Sharing</h3>
          <p class="muted">
            The Share button generates a URL that contains a description of the
            current region. This can be saved, given to others and bookmarked for
            future reference.
          </p>

        </div> <!-- fixed-container-narrow -->

      </div> <!-- /.container -->
      <div id="push"></div>
    </div> <!-- /#wrap -->

    <!-- Site footer -->
    <div class="footer" style="margin-top: 50px;">
      <div class="container wrapper">
        <div class="footer-collapse">
          <p class="muted">
            &copy; 2013 Intel Corporation
          </p>
        </div>
      </div>
  </body>

  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script src="//code.jquery.com/jquery-migrate-1.1.0.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-hashchange/v1.3/jquery.ba-hashchange.min.js"></script>
  <script src="//cdn.jsdelivr.net/jquery.hotkeys/0.1.0/jquery.hotkeys.js"></script>
  <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>
  <script src="/js/site-components.js"></script>
  <script src="/js/site.js"></script>
  <script src="/js/gen-regions.js"></script>

</html>
