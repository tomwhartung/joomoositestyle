<?php // no direct access
 defined('_JEXEC') or die('Restricted access');
 // This is a JDocumentRendererModule object
 // $this_class = get_class( $this );
 // print "Hi from mod_joomoositestyle/tmpl/default.php: this class = " . $this_class . "<br />\n";
?>

<script type="text/javascript">ViewFunctions.printModuleOpenDivTag();</script>
<noscript>
 <div class="mod_joomoositestyle">
  <p>The Site Style module<br />requires that you<br />enable Javascript in<br />your browser's options.</p>
 </div>
</noscript>

<table class="mod_joomoositestyle">
  <?php if ( $params->get('show_font_size') ) : ?>
    <?php if ( $params->get('font_size_type') == 'D' ) : ?>
      <tr>
        <td class="mod_joomoositestyle_description">Font Size:</td>
        <td class="mod_joomoositestyle_input">
          <script type="text/javascript">ViewFunctions.printFontSizeSelect();</script>
        </td>
      </tr>
    <?php else: ?>
      <tr>
        <th colspan="2" class="mod_joomoositestyle_slider">
          <script type="text/javascript">
            var sizeId;
            sizeId  = 'current_font_size_' + ViewFunctions.instanceFontSizeSlider;
            document.write( '  Font Size (<span id="' + sizeId + '">' + JoomooSitestyle.font_size + '%</span>' );
          </script>
        </th>
      </tr>
      <tr>
        <td colspan="2" class="mod_joomoositestyle_slider">
          <script type="text/javascript">ViewFunctions.printFontSizeSlider();</script>
        </td>
      </tr>
    <?php endif; ?>
  <?php endif; ?>
  <?php if ( $params->get('show_background') ) : ?>
    <tr>
      <td class="mod_joomoositestyle_description">Background:</td>
      <td class="mod_joomoositestyle_input">
        <script type="text/javascript">ViewFunctions.printBackgroundSelect();</script>
      </td>
    </tr>
  <?php endif; ?>
  <?php if ( $params->get('show_border_color') ) : ?>
    <tr>
      <td class="mod_joomoositestyle_description">Border:</td>
      <td class="mod_joomoositestyle_input">

        <script type="text/javascript"> ViewFunctions.printBorderColorSelect(); </script>
      </td>
    </tr>
  <?php endif; ?>
  <?php if ( $params->get('show_border_style') ) : ?>
    <tr>
      <td class="mod_joomoositestyle_description">Border Style:</td>
      <td class="mod_joomoositestyle_input">
        <script type="text/javascript">ViewFunctions.printBorderStyleSelect();</script>
      </td>
    </tr>
  <?php endif; ?>
  <?php if ( $params->get('show_border_width') ) : ?>
    <tr>
      <?php if ( $params->get('border_width_type') == 'D' ) : ?>
        <td class="mod_joomoositestyle_description">Border Width:</td>
        <td class="mod_joomoositestyle_input">
          <script type="text/javascript">ViewFunctions.printBorderWidthSelect();</script>
        </td>
      <?php else: ?>
        <th colspan="2" class="mod_joomoositestyle_slider">
          <script type="text/javascript">
            var widthId;
            widthId  = 'current_border_width_' + ViewFunctions.instanceBorderWidthSlider;
            document.write( '  Border Width (<span id="' + widthId + '">' + JoomooSitestyle.border_width + 'px)</span>' );
          </script>
        </th>
      </tr>
      <tr>
        <td colspan="2" class="mod_joomoositestyle_slider">
          <script type="text/javascript">ViewFunctions.printBorderWidthSlider();</script>
        </td>
      <?php endif; ?>
    </tr>
  <?php endif; ?>
  <?php if ( $params->get('show_reset_all') ) : ?>
    <tr>
      <td colspan="2" class="mod_joomoositestyle_reset_all">
        <script type="text/javascript">ViewFunctions.printResetAll();</script>
      </td>
    </tr>
  <?php endif; ?>
  <tr>
    <td colspan="2" class="mod_joomoositestyle_saved_div">
      <script type="text/javascript">ViewFunctions.printSavedDiv();</script>
    </td>
  </tr>
</table>

<script type="text/javascript">ViewFunctions.printModuleCloseDivTag();</script>
