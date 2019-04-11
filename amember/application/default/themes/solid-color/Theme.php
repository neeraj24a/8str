<?php

class Am_Theme_SolidColor extends Am_Theme_Default
{
    protected $publicWithVars = array(
        'css/theme.css',
    );

    const F_TAHOMA = 'Tahoma',
        F_ARIAL = 'Arial',
        F_TIMES = 'Times',
        F_HELVETICA = 'Helvetica',
        F_GEORGIA = 'Georgia',
        F_ROBOTO = 'Roboto',
        F_POPPINS = 'Poppins',
        F_OXYGEN = 'Oxygen',
        F_HIND = 'Hind',
        F_RAJDHANI = 'Rajdhani',
        F_NUNITO = 'Nunito',
        F_RALEWAY = 'Raleway',

        SHADOW = '0px 0px 5px #00000022;';

    public function initSetupForm(Am_Form_Setup_Theme $form)
    {
        $this->getDi()->view->headLink()
            ->appendStylesheet('https://fonts.googleapis.com/css?family=Roboto')
            ->appendStylesheet('https://fonts.googleapis.com/css?family=Poppins:300')
            ->appendStylesheet('https://fonts.googleapis.com/css?family=Oxygen')
            ->appendStylesheet('https://fonts.googleapis.com/css?family=Hind')
            ->appendStylesheet('https://fonts.googleapis.com/css?family=Rajdhani')
            ->appendStylesheet('https://fonts.googleapis.com/css?family=Nunito')
            ->appendStylesheet('https://fonts.googleapis.com/css?family=Raleway');

        $this->addElementLogo($form);
        $this->addElementHeaderBg($form);

        $form->addProlog(<<<CUT
<style type="text/css">
<!--
    .color-pick {
        vertical-align: middle;
        cursor: pointer;
        display: inline-block;
        width: 1em;
        height: 1em;
        border-radius: 50%;
        transition: transform .3s;
    }
    .color-pick:hover {
        transform: scale(1.8);
    }
    .am-form {
        max-width: 700px;
    }
    .am-form div.am-element-title {
        text-align:left;
    }
-->
</style>
CUT
        );

        $this->addElementBg($form);

        $form->addScript()
            ->setScript(<<<CUT
jQuery(document).on('click', '.color-pick', function(){
    $(this).closest('.am-row').find('input').val($(this).data('color')).change().valid();
});
jQuery(function(){
    function hexToRgb(hex) {
       var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
       return result ? {
           r: parseInt(result[1], 16),
           g: parseInt(result[2], 16),
           b: parseInt(result[3], 16)
       } : null;
    }

    $('.color-input').change(function(){
        var tColor = 'inherit';

        if ((c = hexToRgb($(this).val())) &&
            (1 - (0.299 * c.r + 0.587 * c.g + 0.114 * c.b) / 255 > 0.5)) {
            tColor = '#fff';
        }
        $(this).css({background: $(this).val(), color: tColor, border: 'none'});
    }).change();
});
CUT
            );

        $gr = $form->addGroup()
            ->setLabel(___('Layout Max Width'));
        $gr->setSeparator(' ');
        $gr->addText('max_width', array('size' => 3));
        $gr->addHtml()->setHtml('px');

        $gr = $form->addGroup()
            ->setLabel(___('Border Radius'));
        $gr->setSeparator(' ');
        $gr->addText('border_radius', array('size' => 3, 'placeholder' => 0));
        $gr->addHtml()->setHtml('px');

        $form->addAdvCheckbox('drop_shadow')
            ->setLabel(___('Drop Shadow'));

        $gr = $form->addGroup()
            ->setLabel(___("Font\nSize and Family"));
        $gr->setSeparator(' ');

        $gr->addText('font_size', array('size' => 3));
        $gr->addHtml()->setHtml('px');
        $gr->addSelect('font_family')
            ->loadOptions($this->getFontOptions());
        $form->addHtml()
            ->setHtml(<<<CUT
<div id="font-preview" style="opacity:.7; white-space: nowrap; overflow: hidden; text-overflow:ellipsis">Almost before we knew it, we had left the ground.</div>
CUT
        );

        $form->addScript()
            ->setScript(<<<CUT
jQuery(document).on('change', '[name$=font_family]', function(){
    $('#font-preview').css({fontFamily: $(this).val()});
});
jQuery(document).on('change', '[name$=font_size]', function(){
    $('#font-preview').css({fontSize: $(this).val() + 'px'});
});
jQuery(function(){
    $('[name$=font_family]').change();
    $('[name$=font_size]').change();
});
CUT
        );

        $this->addElementColor($form, 'menu_color', "Menu Color\n" .
            'you can use any valid <a href="http://www.w3schools.com/html/html_colors.asp" class="link" target="_blank" rel="noreferrer">HTML color</a>, you can find useful color palette <a href="http://www.w3schools.com/TAGS/ref_colornames.asp" class="link" target="_blank" rel="noreferrer">here</a>');

        $this->addElementColor($form, 'link_color', "Links Color\n" .
            'you can use any valid <a href="http://www.w3schools.com/html/html_colors.asp" class="link" target="_blank" rel="noreferrer">HTML color</a>, you can find useful color palette <a href="http://www.w3schools.com/TAGS/ref_colornames.asp" class="link" target="_blank" rel="noreferrer">here</a>');

        $gr = $form->addGroup()
            ->setLabel(___('User Gravatar in user identity block'));
        $gr->addHtml()
            ->setHtml($this->_htmlGravatar());

        $gr->addAdvCheckbox('gravatar');

        $form->addScript()
            ->setScript(<<<CUT
jQuery(document).on('change', '[name$=gravatar][type=checkbox]', function(){
    $('#gravatar-yes').toggle(this.checked);
    $('#gravatar-no').toggle(!this.checked);
});
jQuery(function(){
    $('[name$=gravatar][type=checkbox]').change();
});
CUT
        );

        $gr = $form->addGroup()
            ->setLabel(___('Dashboard Menu Item'));
        $gr->addHtml()
            ->setHtml($this->_htmlDashboard());

        $gr->addAdvRadio('menu_dashboard')
            ->loadOptions(array(
                'icon' => 'Icon',
                'text' => 'Text'
            ));

        $form->addScript()
            ->setScript(<<<CUT
jQuery(document).on('change', '[name$=menu_dashboard]', function(){
    $('#menu_dashboard-text').toggle(jQuery('[name$=menu_dashboard]:checked').val() == 'text');
    $('#menu_dashboard-icon').toggle(jQuery('[name$=menu_dashboard]:checked').val() == 'icon');
});
jQuery(function(){
    $('[name$=menu_dashboard]').change();
});
CUT
        );

        $form->addHtmlEditor('footer', null, array('showInPopup' => true))
                ->setLabel(___("Footer\nthis content will be included to footer"))
                ->setMceOptions(array('placeholder_items' => array(
                    array('Current Year', '%year%'),
                    array('Site Title', '%site_title%'),
                )))->default = '';

        $fs = $form->addAdvFieldset('', array('sct-login'))
            ->setLabel('Login Page');

        $gr = $fs->addGroup()
            ->setLabel(___('Login Page Layout'));
        $gr->addHtml()
            ->setHtml($this->_htmlLoginLayout());

        $gr->addAdvRadio('login_layout')
            ->loadOptions(array(
                'layout.phtml' => ___('Standard'),
                'layout-login-sidebar.phtml' => ___('Login with Sidebar')
            ));
        $fs->addHtmlEditor('login_sidebar', array('id'=>'login-sidebar'), array('showInPopup' => true))
                ->setLabel(___("Sidebar Content"))
                ->default = '';
        $fs->addAdvRadio('login_bg')
            ->setLabel('Background')
            ->loadOptions(array(
                'none' => ___('Transparent'),
                'white' => ___('White')
            ));

        $form->addScript()
            ->setScript(<<<CUT
jQuery(document).on('change', '[name$=login_layout]', function(){
    $('#row-login-sidebar').toggle(jQuery('[name$=login_layout]:checked').val() == 'layout-login-sidebar.phtml');
    $('#login_layout-standard').toggle(jQuery('[name$=login_layout]:checked').val() == 'layout.phtml');
    $('#login_layout-sidebar').toggle(jQuery('[name$=login_layout]:checked').val() == 'layout-login-sidebar.phtml');
});
jQuery(function(){
    $('[name$=login_layout]').change();
});
CUT
        );

        $fs = $form->addAdvFieldset('', array('id' => 'sct-css'))
            ->setLabel(___("Additional CSS"));
        $fs->addTextarea('css', array('class' => 'am-el-wide am-row-wide', 'rows'=>12))
            ->setLabel("Add your own CSS code here to customize the appearance and layout of your site");

        $fs = $form->addAdvFieldset('', array('id' => 'sct-bf'))
            ->setLabel(___("Tracking/Widget Code"));
        $fs->addHtml(null, array('class' => 'am-row-wide am-no-label'))
            ->setHtml("Add your own Javascript/Html code here. It will be appended to each page content");
        $fs->addTextarea('body_finish_out', array('class' => 'am-el-wide am-row-wide', 'rows'=>12))
            ->setLabel("Shown if User is NOT LOGGED IN");
        $gr = $fs->addGroup(null, array('class' => 'am-row-wide'))
            ->setLabel(___("Shown if User is LOGGED IN"));
        $gr->addTextarea('body_finish_in', array('class' => 'am-el-wide', 'rows'=>12));
        $gr->addHtml()->setHtml('<br/><br/>' . ___('You can use user specific placeholders here %user.*% eg.: %user.user_id%, %user.login%, %user.email% etc.'));

        $form->addSaveCallbacks(array($this, 'moveLogoFile'), null);
        $form->addSaveCallbacks(array($this, 'moveBgFile'), null);
        $form->addSaveCallbacks(array($this, 'updateBg'), null);
        $form->addSaveCallbacks(array($this, 'moveHeaderBgFile'), null);
        $form->addSaveCallbacks(array($this, 'updateHeaderBg'), null);
        $form->addSaveCallbacks(array($this, 'findInverseColor'), null);
        $form->addSaveCallbacks(array($this, 'findDarkenColor'), null);
        $form->addSaveCallbacks(array($this, 'updateVersion'), null);
        $form->addSaveCallbacks(array($this, 'updateShadow'), null);
        $form->addSaveCallbacks(array($this, 'normalize'), null);

        $form->addSaveCallbacks(null, array($this, 'updateFile'));
    }

    protected function _htmlLoginLayout()
    {
        return <<<CUT
<div style="float:right">
    <img src="data:image/png;base64,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" id="login_layout-standard" />
    <img src="data:image/png;base64,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" id="login_layout-sidebar" />
</div>
CUT;
    }

    protected function _htmlGravatar()
    {
        return <<<CUT
<div style="float:right">
    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAABmCAYAAAA9BvYaAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH4gwGCxcmrBhMfgAAIABJREFUeNrtndmTXcd93z/dZ7nn7tvc2TdgBvsOEhBJkSK126blOLaSlBNXxeWqVPk1j37Lf+CqOJWKy+WHlJNYrsiRbEuWSFGURIIExJ0AiH3H7Pvc/dxzujsP986AIIHBgBtA6nyqbrGGOGuf8+3f1n1alMtlQ0RExANDRk0QERGJMCIiEmFEREQkwoiISIQRERGRCCMiIhFGREREIoyIiEQYERERiTAi4jcK+353EEIghMCYaLRbRMRnKkLLstZ/UkYGNCLiMxWhZVm4rotlWQgholaLiPgsRSiEwHEcbNuOWisi4lPgnn5l5H5GRDxgEQohsCwraqmIiAclwoiIiEiEERGRCCMiIiIRRkREIoyIiIhEGBERiTAiIiISYUREJMKIiIhIhBERXyge2lHZS8vLXLt+k7n5ecq1JoFxyBS76S51U8pn6cnHScaiPiQiEuEnzszMLMdfPcGrJ05w9twFJqZnWS7XCa04xd4hBoaHGervZ9vYMI/s28nBXVsopOPRk4z43CLutSCM4zh4nvepX0gQhLx7+gzf/38/5Cc/fY4Ll68TBCGELYxWCCmRQiJtG9tLki70sH37dr721FG+862n2bdnJ0403SoiEuFHo+X7vPLrN/gff/O3vPiLX1GpVQmlCwoI6qAVBgNKgQ7BGISUCCHJ5PJ88xtf48/+05/wxGNHcWNu9FQjInf0/ixgwInX3uS//uVf8fzPf4kyGmkJhN9EawUqaPcW0gJpAwJhDFKCjaG6uMDPfvZLcr1bKPRvZc94P1Y0+T8iEuHmMAbOnbvAX//13/Dcj/+ZZqDwMhmMCtF+A0cYPFsQYOHr9j7Stsg5kn7HxXU9Aq2xu7cy7ed5+cIKpa48ffkoRoz4/PBA04vlSoVfvvQKx145QSs0xOJxpCVBGKQJidmQjrnEbAtjDI4tKCQEQykoeNAMfCq+j2iUEfMTXLgyzcnrKzRaKnqyEZEl3Awzi6u8dfYqOtHNwW8/TcuvMX35HZr1FUCBUBjHQmiNUD7aQMJ2KSaSBJluFlYq1HUT26+Tu/Q68z19nBrqZtdgluGuxBfmIbUCTV0ZYq5F/EFXZYwhNIAQ2JHb//kWYaBhcqHK7EqddGmQsS99i+rKLPNTF9CmTJh2MFrgijheJk3orIKGdDKF50pkvpuklSAbS9Db1YOeuUpz6hILiweZWmnQl/dwrLu8sUYTtBr4AVhOjJhrIwWAIWw1abVCjOUSi8Ww5e37hX6DZmiw3Tgx12L9PTSKwG/iBxrpxIi5DpYU6//WajYJlEHYMbyY0z6fUbR8nxALSwp0qJCOi+u877hoLl9f5YUFw75dWZ7KWjzIj42E1RaXaxo7H2csFgno8y3CUDO7UqPaaOIlE3jxBH7NxqAITAtlK7QlqeiQpFTYmQTdxTEG+wdRU2eRtkUq7uIVe8gPjuOvzGJXl2nWm8yu+oTK4NzhbVV+mZnrZzl1+jwTC5p0/zj7H93PWFeMyo1zvPfeWa7NlFHJHsb3HmDfjiFyMQsT1lm8fo533znNtSVNdngXBw7uYUtPCiuoMX/9PKdOnubqQpNYcYQdew+wd6wHL1hl4uJpTp+7xMxKiFsaZc+BA+waLeH4i5x/6y3OzzRxYjZhXTJ8+FH2j3dz6/02LK34nJwx5MfacfS6Qo1htRYwXVP4RpCM2/SlbJJWe79mUzFdCVkNIeEKHEviuRbdCYmFoVoLmaqGNIzAi9n0pW0ytqHpK5ZbkPIs0o4gaClWWhplCeaulvmn6ZDMKDzb59CbsklGYyY+nyIMtWG13sRvBXiJHI5jgWqB0kilEaHG2BaBVDR0GUdbiHoZC4NyUujpKRKOg9tj40kLV8ZwvRQBknIzROk7VF50ncn3fsU/fP8nvDujSCUTJCaWcHr66IqluPH2MV5+4zJLjZBa+TivnbnBs3/8H/j2jjSrl4/zw7//Ecev+ySTFq03T3H2xrf57h9+haHaSZ7/4Q/41bllvEwKJ7FIWZQYGirB4g1OH3uBl65WCYMmq+UTvH11gX/3x3/IYXeB9379c/7+ufPEB4YYGdpFanwPH4xopRTYFu2s7/sEODdf4/kLVd4tK4yQxOMuR7emeWbQxW20OHZxlRemAhpIipZmwrfYPpzlz/Z7BCt1fn6+yusrIRqJ7Toc2pLmmwM2yzNlfjAlOTqe5qmSxepCnR9fb9LIuejrdZ6fCMn6khQpvrbFJhlVhT6fIjRG4zebKK1IJ1LYjoVWPhbgWg6hDca2EFJC0Nm+ukR9ZgIvkcbYK8RWFvEmr6HqVdyYR3x0F9pNUPdD9B0+0x9WrvP28V/w8iXBo9/5I549VMT4ilR/nmTcpX/XIzyR30HoL3Ph18/xL6fPcfL8Ml8bKnPm9Rf5yRsL9D/5Hb5z2OXMz57j1Rd/xfjOUbL5a5y7eIF56yDPfuVJdg4UyJWGycYs3EyJ8Ue/gtwOVv0aJ154jmNvnuHAU9/m0LaAWqXCctVj14Gv8wffeoStg++3gndHt5q8fL7M8VXJ4ztzbJOKkzeq/PKSoOilyK5W+cm1gFRfimf7bCpTqxw/2URm0+jA5/j5Mi/OwaM7s+z1DBdvVnjlYpmMk6avGXB5STLud2LSZsC1xRZ2McH+fIytdYstY2me7HXpisZHfH5FKDF4+CRsQz6TIuNZzIY+tgDXcai7BuFIjJRIY+FaknzfFpKpLDKVJza6nalXf4JaXiBR7MbdeQhv215M3MOWgjvlDFrLN7g5cRUz+i2e+OYzHOi95fKF9SWqtSpz188ztbjI9GyZZiNHvRwSrMwxceM8k3VNbvk6588KphdXqM5VmJ1dQIyPs2vrODfevcG7J15DP3qEI12jWGhCFVApLzN56SZLK/PMrjRoNULqqwEIgbRjZEcPc+TJr/PoruzmkzWVJieXFNmeLL83niSDImd8zp3xOT8tSdVbVGMe3xlL81SXpOUFHJ/RVG2BqjU5uRjg5vN8Z0eKEoZhO+DUGw0uLrTIJgWuhLWQVgiBJdrubm/apj8tGOv12J6N/NDPtQgtASlbk4lJRrszDKQEl/xVHCHIewl8R1C3FAaBlJKY5dBd6qY7kUDF0qT3H2Zy4gKNZovMY98mO7INGUvgWJJMwkbKO8hQB2gTIGMxYreZG5+FS8f40T89x7lqjvGtveTzObxJC2kEaIXSAcL1cCxBGAqK4wd5ZneevVt6yPYO81vfdegaeY23T57j7R99n4nJBql/cwD/vR/z9//4Fo38ODv6iuSyGdwKCLPua2InUnjx+xuVFAaKmhEUPJtMWyokPIs4LepNhQna2dS8224HN2ZRjAuaAsJAU9GCpGeT6xwvHrdISoPfUrSSbbd3rQUFbUEaA9oYtDEoDZpoGs7nW4QS4q5FzLGgVWPx2hmmLp6mUa8RcyWegpZtMBLQBqM19blJZKmbgfEdZPqLnC3kUVowsnWEbFeeVqBwHYvudOxWZvL9N5vtp1ToIXjrLV57aR/F3TlUKySZsViaPMvZiVnUzsc5sK/AVOU9tNEYo7HSPZRKo5TseTK9WzlwsAtZr1IOc/QX84jqLLOVgMzWw3w56dL43j9z/ex55uaLVC6/zekFzaOPPcLhvnmOXQgI3pd0ufW7h+cgIObI9QeWSsfotutMrDaZJMYAmvnlgBVtsTfnki0HvLLc4lpNcSBjU64EXFnSiCTYcYeSbTiz2uS6ijNuGZaWWsyHkj0ph4wMUIGipsx6Eq0eQlG2X5gg1GgTCfBzL0Lbtukq5AhbPq+feIV8LsfqwiyxRJJEroulmRmkURipMUbR0obJ6QlC32cxmcFbWWR5fpZCoUjBUfSkLCoNjefZ9GVjdyxPOJkxDh39Bpev/BPHv/eXnM6mSef6efzZb7One4zhzDu8/vbP+cGER2PqCpV6P0GoID7MniPf5uvnv8/rr/6Q753JEANiQ0+QGx1nQFzk+E9/yutX69iyxqKfYuTwOD1dvSQHx+iXv+bMz3/Aaspn9vIsgTVM2EkchUGI3wrunEhaj58NszN1/uH4HFdSEglkiy7dJY+52Qr/7Vct+qRmZiWk1JPmYH+CdFpzeqHC82/Pc+Gqg1upcbYK2w3IeJynRptMXaryVy+HDDuG+eWAZDHJo/1xBgPFVrfCifcWmJmULC4HNJIee1IWfaFF6nKNn72xgLsjxZeH4oy6UcHwYxmkP//zP/8vG25gWZ/KYjBSCFqtFucvXCLQgoHhEcqVFXy/RSzby0LdpqWTaO0hjINnWQyMbWfg4FFC26W8ssLsxHVUEDCyfS/xQjeB0vTkEmzvy5L0PnzNwoqR7ephoK9EKhEnletiaGwHu3btZsvQED25DJl4klz3CNt27+fA3n3s37+TsYEcuWIPA/3dpBMe8VSenqExdh3Yx+5tfWQ9G61AWjHSXf3sOPIkT3/1MXYM9ZHPdVFKp0kl03QNbWPX3oMc3LOHfXvHGSq6KBOje3CcfbtHKKXkXUTY/lkClDK0FNipGEeG42yLw2pd0zCSvu4k3xhLsjNrkfVseuKCoKVZDQV5FyqhIJmL89XBGAMZh4IL1bqmpgSFYpyvb0txoGCTjFkUXEkYaFZ8SGQ9ntiS5JGiS96TeDb4LYObdBjOORSiqv3H4oHOoqhUqjz3wi948eXXWalUOfveuywvLOCmupiuKuraRSvwbEPObfHU17/OY7/zb2nWa8xcvcArP/6/gOC3/+hP6R3dTiomObK1yPa+zN0L9Ri0CgkDhTIGIS1sx8ESoFVAGCo0Aina9QBp2di2pF1bDwnCdvlDrE2rsiQSQxiGhGE7hhWdjsuWol3gDwJCpUFI2ivLSSzbxpbt/ZQR2LbD3S5Za0NLGTreIaZTtnAtAdoQaIM2YEmBY4lbA9hNO24TRnPxwiJ/ecanb0eJ/7wrRlx2BN3Zd+14a/u+/5xCtI9ry3Z8GCpNS4H4wD4RnzN3FCCdTnL0yGGWV6v84uXj1Ot1kqkU8UyamZUZ4q0KMWOR1YIiIYmFOerXzrNQazA3fRMDpPMFYl6crCfZ2p1kuJjcQIB0hOXgWs6Hrb7tYm3QIsKyce+4gcB2XGznTv8ksd3YXRq6s9+9vAYp8KS4a4bLvqMKNFPzDX5yvsblasBy3ZAoJni632bNe7QsQfwuCtronLYlsaM1gr4YIgTBYH8f//r3nsVyY1y4cI5cvkCub4zzs3XcYIEhVaHYbJENJPr021xdWSa+bTvDfT0sZFJIoenyJDt604z1pkl5UeFqXeC2IJewKAnBaH+MQ4Nx9uasyHJFIvxgjyvpKmT48tFDnD/zFHPlBo6bYKQYJ9M7RvzaOeKVKq50CRbm0dqw9cgRenbu5tJ7p1CBz9buFDsHcqTiTrSS8PtE2F1I8IeFRNQUkQg3x9joEH/6H/89Zy/f5PUTv6Y3KUjYFk2pMQIQAoQgmU6TKxbxEkl27d7Blr4ih/aMkUlEY6ciIhF+vAuxbXZsG2NwcICR3gLbx0e5ceESk7pOc2oW02iQzGTpGxthqK+LLdsGeXTsX9FTzJDP5aMnGfH59Vkelg89fZBGs8nC3DzLU9P45Qqh7+PG4ySzWfID/eS7S7hRdiAiEmFERMTHzotETRAREYkwIiISYURERCTCiIhIhBEREZEIIyIiEUZERHz2RKOdIz4zGo3GprZbG/9rjIlE+EljgEalQnlmmkZ5Ba0ens/VhxpkOo2VSHY+7hnxoAiCAMuykFJGIvykafotVq5ewrz5CvGFaQTv/5Ltg8MYw1LLEHvmt8gNDWNUtJbFg0IIweTkJOl0mng8Honwk6YVhvgzkySunsOtrcJDMu3IGJDGISYgmUqhgyBSw4NKUkiJbdt4nkcikYhE+EmjjcGEAUIFoPVDJULRcZeNNr8xscjDiDHmtl8kwk8pLsQ8ZEG3ASPa16ZNJMIHidb6NkFGIvw0fH5j1n8PVSxyezcR8RBYxN8UHoglNFpj1Cbc0bVv/d1NNaKTPTP6ztrpzMbf1DVZ5kNyjIj4Qoqw/cabe5cBhMDqH0bmix/qFYUQmGYDNXkDMFj9w4h44rbthJDopXnU3DSocPNuqdGROxpZwy+6CE07+aHNxkbHksSe/i28L3/9w4IVAjV5g+rf/neMViS++yfYw1tv304ImsdeoP6Pf4eplje0iGbtuiJXNBLgb4QIMRi1GXdU3HIx77SdEG0h6/fVGu+03SZcXwNgm/WHH1nCh0OAkSX8FN3RTb3oZuOFUszaQ9IbbLfJc5l7n+4+XhrR1rsQUXQZ8bBawrWY8B4La5l7OYe34kqz0eu+mXPdkuL9WUIh0H6FxdkZZhbL1FsahI2XLTEwUKKQdBDaYIRAPAyi7CxrZj7gtsv1z/M/PJbw43gkH9xfCNluf/HR2sx8ys/ugcSEaA1Kb6wLITZO3rSLeu0hZmF7hIsJbyVghG23/1a6MzBgMxb6ftxRgWXqTF8+xRvvXGCyptecbZz8NqSXJBv3WLg2Qd3L09Nd6Kwl/2AQwtCsLnHj0g3may2MbK9j4eS6GBwepiflYouHKyr+KCI0rTpLC7NMzS5Ta4ZoYRHL9jAy1E0h5d7ftCEV0qxV8GNZMjH5qQnxsxXh2l3otoA2zpBuIoOKwKws47/+KuHVS22xrSd2bILzpzG+3z4fH8/9/RDSQlYnOX3qApNihKd//zF29ScRzVUWFlrYXgLLNJm9dpWFHKSLRVJSESrdWcpbdCossrOWokF32mTNPRZSYlkSgUYrgxES2VmF2GiFNgIhBUbr2/cTAmlZvH8pCSE01fnrvPL8C9y0s5QKaVyt8PoUXlcfpZSD0YpQ63ZTiPa52wvjGJQyCEx7zUYsLKs9uqjtPdy63vYaOO17FEJ+6Do+NQEKgfHLTF48zVtnrjNXCdpZdBQy1yKRTpGKWbj22j2BVmq9TdEKpXT7Dejce1hd4trJUyyNHOFgX4q4I9fbXun2Go3iQ+2kb88tiPbzXWuT9mJAne2NRin12YqwfQPmVp3wnpbwHqZLCMK5GdSPvr/xceCe8SXmPhMzBlToo5HEXAcRNKmXBbYVJ19KtvsbE5IuFDDJOC4h9eVprt2YZq4SYrseiZghtHvYOlwkppa5cXMJjUapkEbLEM93MzTYR8Fa4vrNFYJYF0O9WeIxKF+7zM0wQXd3gvLELDU/AEvT8hU4GXqHB+jNxVlbtcx0RJrsHeJLT3yLZ3YNkrXaL4EKFWGrytzUJBOzy9RaGhnL0z80QF9XirhY5cq5OZAhjVqNeryfbX02MxMLGDShCmm2QkQsRzEj8SsVKvUAGc/SPzJEbzb+kazs5oUokFKxOnmO46+dYimzm688e5idAznscJWFZYWnZzh3bpFiXx99hTi2pVg8f5rJ1BBbezwaN69yfb5KywjseJaB0R7Cq2c5cfwtVhZcrB1DbN0yRNFusTwzwfXpRaq+RsZy9A8P0l/KkGCV82enUUYRqJCW79MUOQZ7XerLFRq+j69cesbHGS7ECFenuXJl+rOfynTbi76hu7kJK6gUMlcg9sjjyEIRtLrNEoaXL9I68y6m5d8zO7qZ0uXtOylMopfhwTzT5y7z2rEyN4pZsoUivb09lApp4rLOlZMnmeyBTMFm9c3XePNmFSueJm0FLM9OMG0d4ru/u59s/QIv//IsVlcvA6UUzYU5VpimQoqjxUnee/citex+CsU0yYRg8exbHG/08ugjPVx+5SWuNJNsGe8hZVqszp3nymLAk0fH6U87t/U/JgxpVMqsrCyjpQFpE3MNizcu8OY7F5n3JTHXolW9wrX5Gkcf3cO2zBLvHHuZWe1SKKaI9+UYSJY58fPjVDM9jA7k0LVFrl+vEC8UKHWlsRorLKwETNZtnj40QiEuN+1oCCHu0xIKhCpz48p1FunhkaMH2N6TRAQ+IXEKXTHsqVc59mqNXY8n6cp5OE7I5Gu/4qWBb5KxAk4ee4t5mSSXSRJLhmT7soSVVZZqPvWVZZZW8gyEAStzl3jj9TNM+xYJz8IvX+XaXJWjRw+wK7vIm7/6JXNOjuGBLjxWOf/e25wqFunuyhK3A5auXuHUcozf/1Kam6+d4OQCn70lbC+a14nTzMZb62YT4/uYDxTbhWVjGnWM7yMLJRK/8wfY/YMfOkLj2IsEl85iGvVbo2vu4Y5u3hIqlF1gfN8RLOccZy5PM3FllquXwc0Nc+DwfnYOGiy7vQqSP3uWdy7VyB14ht9+Ygup2k2O/eSnlBfb6yCiNMKJU9p+iKe/tIPkzBv89KWzzEyt0EiZ9nqGlugkV9qdjG1bbdcTRbx3jEeffIxtOcPsmz/i/7x6jhujPZRSBexObRYgqK0ye/odxPw1YkgyPcPsGIFzZ84zHfbw2DceY+9Qmtq55/m7Fy9x5WY3AzsNUtfwE1s48NUvs7vbQy++i8SQGt3Dk8/spdC8wQv/6x94u7WFrz7xNXan5njtxV/w1sQcKzv6yMW9Tfdy952YEUCzTLnWwE100ZV2wKy5fwalFAKJY9u0m7DdHsJysC2BqU5zs+Iw9sRRju7uJ2OD7Vg0rT1MXljA/8rX+Oa2AonWTU6cO82VSp6nfverHBxKUT//Av/7+YtcvN7HyB6QoY89vI2jzxxmSyHk17N/wffm+nnq2afYN5Bg9cTf8BfHrjPVF/DKyRXGf/c7D2DYmrnlkt4r0vXfOI6am7ljsV6XVwkXZrFKvZhW8y5BegutNFobhNB3PY/uJFTuLzFD2xInutnxpV62HaqzsjDH1PX3ePGlM7yZyNJV6u+4gZra7BxNr5s9PQXihIR2mqGRPGd8C6012tgkEll683EsHaKkxHIsdBC24wxj1gcUmM4o+LVr1SQZLKXIxAx+S5Ma7Cet3qNaq9HSBWzW9jPtuM/3aTYaKCzcQNEqL7NYh0xXN6WkRdDUpAaGKMobNCorNEIPRZpt2/vpy9roMEApg2VlGOlO4UlNENp0FVKUMn0kHYEx4CRd7GqL0Kh2jHgfIrw/d9S0F2cVAqUUgdK3e1prA0TW2tAYNAYj2n+L7E6O7DjNtSvv8tLsJQpdw+zYMUQ8CAmVJmy1aAUhdnWZ5apPvGuQ/oyk1VAk+wcpuldolJdphB5apNnamyFpa/yWTVc6Rik7Qj4mUK0Au5DBM1Uqc5PMB0lGps5/1iIU7QdhVLuILjdoZKVpnX6H1tmTd08dN5vY3X13t6hrmVit2tnAjbpS8xF6YKMJdEArkNi2S653C6WeBHOXZjjTrFFtmfV8j7BtpA7wgwBlwNIhfjNEqY4FXvfXdfsvY9rXBJhOEK+1AiOQaJTWCAPCtGPPejPAVxphGfx6gxYSIa11sSLa/3WzJXY98TWe3jlAVmqUEajFd3CkodFZUVgIg/J9AiNxpNWZfL22rmGnsxIgEesvNAiwJFi8r6MQSNriM/fp79/vczBuimwmiZ5bYmq+Ql/KJenIdvJD605uLmyXaIRAGo1SGgnYySEOP56geOUqN25OcfXt46w6cY4UNYJOAky0k3HCkqigRSswEIOw1SLUAiEtBCBNp01Mpw2kRDi36trGSCQKKR1sNM3APKA6oW4LROgNhCEF8Se/irvn4O2xXiczqRbmqP/8X24rS2xQd9j4XGJNKffXoUhVZ352gaW6IJFOkow76PJV5huCXClD2mmPRdUGkj2D5C9eYOLGNW7mhki1Zrl2Y5lKvatTjdHojgu1HqNq3f45KVKuYbm2yOxiEbvZYLoS4iQ8Uo5E0GRqYpbJyQWcTMjU+Ru0UiUKmQROR+CCtjXQShH4LZpNn5jUaCRWoouevMfC4jTXpgrIIEH9yjXKVoat+Txxu7qe3VsXhjBtC84t62K0Rneyq0YYtNAooz+Dr4VotEwzMDJC78RJLp1+jwTjDBYSWKpBTSUpyRRZa5bV5XnmF10CscBUwyHrubjhCsuBRWFkF129ecK557i6WKOVkzgyoLqwyPKqi4znKBWyXLt6g0uTJazuJPUrV1khzUihQNypYFh7hp3OtdMmes0oC40WAq+0jdGuRYoDWx7U2NHNZEcl7t5DxJ/+5p0N5ew0zdePd2qEZoNaogZlMFJvIFVxy93T5rY5bRtdnzQB9aUZLl6aoaYM0rIwrTphboi9W/spuBBLJEjEHOKlEQ7tWuLNK2d59aWbJB1FtdpCWxYGgWW7JBJxXEu2vQRhE4vHibsCvBJbRgcpn5vk9OtLXCCgGuYYGeqjFG8gLRerscDV028yoZqUqzG27t3JUCGB1Hq9GYTtEE/E8WyJ6PTW2iiwCozt2EHl9EWunnqTCUvQqgUUR3ezpT+HK33iqSSea3XEDMayiacTxDrHAokTT5CI2Ug0xggcJ07Ci63HYXSu5V5JmY8SFxpjke4d4/Ahn7fP3OTMm4tctCXCaKziOF/aM8T+7aucnbrIa0vXcXST1dwYBwbypPQy7566xHS5BSiC+Ai7hgpkM5rugSwXLrzJiXArew/vYWjbblZqp7j27uvMOBK/GpAb2cnYYAHXarTbybGRnXdJxlOkbKfdBtqA9EinLFKlXRzd8w5vn339wcSErI35NPqu2hFCYzb4zITxfVCqfWNmI8G3RS/MBtlRIW4Zzc2m8IxBySTF/hF22SmWqw2C0CDdFKWBAfq6MjiyxdjBRxiIZch5SeJ7HyFWmGZ2pYXWiiqrVHwbYbVd2cNui1Q+iVQBJl5ifLdHy0rjuUkyW3Zx0Msys1ilqSRbi30M9XeR0tcRIsHQaB8jg3lMI2Q418vIUIlMTL7vJRYk8gMcOJLByqdwxa3ZIloJ0r1bOODE6ZpeotxUWMkiw4M9FFI2xuTZ//gjWNkc3trzcXt55MtxvFIWS2twE/TtPULcyZN2DKFI0jOyl1iPSyFhb0qAH6dWaIxCWUn6xg+QyPYwMbNIpRGghU2y0EUy1UXv/kN4hRkWyk1CHHb0jzBDpwDWAAAECElEQVRcSuFqRW9vLzLpo7FI5PsYHcqStDWjjzyOubFIy8viCUmya5j9j7jkJ+cpNxTW1i6GBnsoZiyUKXDgy0ewC0U8KdBKk933JM+ILjKxtlNv5/fxzFOCnlyRxKGjxPITD2gA93oh86PHBGuJBswm6n/GYMS9aydGcB+z/g1G2CQLfYyXBtYLwNB2+bQ2aOPQPTKKMB2XxE6SLQ3gZQOay1OcvmqT7UqRSsSIZxKMZNozy41SaCdNd38GgUFpDSTpGd1J31bRsUYapYE6aG2wM92M7d1DwWpnbsOw48qut6fATeYYShc6hf5bLhIYQixSXcPs7h5pW6NOIVkbjRIJhsZSHZe07V4KO8vI9jxGte8N2yU7sIV8J15VxMh0DZATrCfHPooA76tUYRRa2GR6RtjXt2W9KmXWCvGiyOjOEls7hfX2/zcYK8/ozi62SrHuQrYL9xbJri0c6BlDGI0KFdpAojDI7q6hD7STIjRJhren221iNEaDN7idnUYRdhJDVnKQXdsNKtQYkWfL7uIDHDt6j4cihEFs8Mk7Ydm3xYh3Pobc1Lna5mAtEWLu6z60Ue2EyV1HPoXrL7pqLnDmjZNcmlwmkDZebpg92wcoJgUqVLef2Whu/+ibRoUa9QGXWAibZCaNiNnooEVLbdBpaEN4N1fbGLQKufOtaMJQf2BzTRjo270OFfK+j1O0O6OPMVztIw1bW7sOdWeRhnf+hw/d361dPnwss1E7BR9opzAguO2xhqxv0rmeBzOpd2141kZPSGjUwjzh9NSHJ+VaNuHkTUyzidGacHoS4cXXx5AC4MZQi/OYUHXikQ0uSbxvTuGnOJVJ2CkGx7aT6vHB8Ujni3Rl4ziYTk3r/hMSyi6y/4lHEV6SuDBfqE+mRlOZPj1n9FbQfY8aXPWn/0zj1Zc+ZJ0EAtPyCWdnAMPq//wrZMy7bTshJGp1GV2v3TYs7e7e6MeYy7RpESboGRqlrzM43Zi2m/aRXzZjMNKj2B1fnyERCTAS4f01sth4CpKamSScmrhraU903NDw2pU7PjQhxV1d1Q+p0NxjStQn1AV9VBdtw2PqaBJyJML7Ngls7iNMlo3YzPQf+QlMMxEfSBpFRNbwM+IBfexfPFwfNRPRHPhIgL9x7minticevgcfWcJIiF94Syg2+S3QiIjIEn4aihcCK5uHUh/U6hD4D487anT0NkR88UUYc2yS23ZQf+qrhPk8ZnX5IVkLUKByBULHoVGvR0ujPdD+sD0dyff9zY3h/SLcc7lc3lAFjuPged4ndsJWq8XK8jLVanXDkSYPQojrVjEi4osswoiIiA+EaVETREREIoyIiEQYERERiTAiIhJhREREJMKIiEiEERERnz3/H1diA1NUqtqZAAAAAElFTkSuQmCC" id="gravatar-yes" />
    <img src="data:image/png;base64,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" id="gravatar-no" />
</div>
CUT;
    }

    protected function _htmlDashboard()
    {
        return <<<CUT
<div style="float:right">
    <img src="data:image/png;base64,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" id="menu_dashboard-text" />
    <img src="data:image/png;base64,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" id="menu_dashboard-icon" />
</div>
CUT;
    }

    function addElementLogo($form)
    {
        $form->addProlog(<<<CUT
<style type="text/css">
<!--
    #logo-settings {
        display:none;
        border-bottom:1px solid #d5d5d5;
    }
    #logo-settings div.am-row {
        border-bottom: none;
    }
-->
</style>
CUT
        );

        $l_settings = Am_Html::escape(___('Settings'));

        $form->addHtml()
            ->setLabel(___('Header Logo'))
            ->setHtml(<<<CUT
<a href="javascript:;" class="link local link-toggle"
    onclick="jQuery('#logo-settings').toggle(); jQuery(this).closest('.am-row').toggleClass('am-row-head'); jQuery(this).toggleClass('link-toggle-on');">{$l_settings}</a>
CUT
            );

        $form->addRaw()
            ->setContent(<<<CUT
                <div id="logo-settings">
CUT
                );

        $form->addUpload('header_logo', array('class' => 'am-row-highlight'),
            array('prefix' => 'theme-default'))
                ->setLabel(___("Logo Image\n" .
                    'keep it empty for default value'))->default = '';

        $form->addAdvRadio('logo_align', array('class' => 'am-row-highlight'),
            array(
                'options' => array(
                    'left' => ___('Left'),
                    'center' => ___('Center'),
                    'right' => ___('Right')
                )
            ))->setLabel(___('Logo Position'));

        $form->addAdvRadio('logo_width', array('class' => 'am-row-highlight'),
            array(
                'options' => array(
                    'auto' => ___('As Is'),
                    '100%' => ___('Responsive')
                )
            ))->setLabel(___('Logo Width'));

        $g = $form->addGroup(null, array('class' => 'am-row-highlight'))
            ->setLabel(___('Add hyperlink for Logo'));
        $g->setSeparator(' ');
        $g->addAdvCheckbox('logo_link');
        $g->addText('home_url', array('style' => 'width:80%', 'placeholder' => $this->getDi()->config->get('root_url')), array('prefix' => 'theme-default'))
            ->default = '';

        $form->addScript()
            ->setScript(<<<CUT
jQuery(function($){
    $('[type=checkbox][name$=logo_link]').change(function(){
        $(this).nextAll().toggle(this.checked);
    }).change();
});
CUT
            );

        $form->addRaw()
            ->setContent('</div>');
    }

    function addElementHeaderBg($form)
    {
        $form->addProlog(<<<CUT
<style type="text/css">
<!--
    #header-bg-settings {
        display:none;
        border-bottom:1px solid #d5d5d5;
    }
    #header-bg-settings div.am-row {
        border-bottom: none;
    }
-->
</style>
CUT
        );

        $l_settings = Am_Html::escape(___('Settings'));

        $form->addHtml()
            ->setLabel(___('Header Background'))
            ->setHtml(<<<CUT
<a href="javascript:;" class="link local link-toggle"
    onclick="jQuery('#header-bg-settings').toggle(); jQuery(this).closest('.am-row').toggleClass('am-row-head'); jQuery(this).toggleClass('link-toggle-on');">{$l_settings}</a>
CUT
            );

        $form->addRaw()
            ->setContent(<<<CUT
                <div id="header-bg-settings">
CUT
                );

        $this->addElementColor($form, 'header_bg_color', "Background Color\n" .
                'you can use any valid <a href="http://www.w3schools.com/html/html_colors.asp" class="link" target="_blank" rel="noreferrer">HTML color</a>, you can find useful color palette <a href="http://www.w3schools.com/TAGS/ref_colornames.asp" class="link" target="_blank" rel="noreferrer">here</a>, leave it empty if you do not want to have separate background for header', null, array('class' => 'am-row-highlight'));

        $form->addUpload('header_bg_img', array('class' => 'am-row-highlight'), array('prefix' => 'theme-default'))
                ->setLabel(___("Backgroud Image"))->default = '';

        $form->addAdvRadio("header_bg_size", array('class' => 'am-row-highlight'))
            ->setLabel(___("Background Size"))
            ->loadOptions(array(
                'auto' => 'As Is',
                '100%' => '100% Width',
                'cover' => 'Cover',
                'contain' => 'Contain'
            ));

        $form->addAdvRadio("header_bg_repeat", array('class' => 'am-row-highlight'))
            ->setLabel(___("Background Repeat"))
            ->loadOptions(array(
                'no-repeat' => 'No Repeat',
                'repeat' => 'Repeat',
                'repeat-x' => 'Repeat X',
                'repeat-y' => 'Repeat Y',
            ));

        $form->addRaw()
            ->setContent('</div>');
    }

    function addElementBg($form)
    {
        $form->addProlog(<<<CUT
<style type="text/css">
<!--
    #bg-settings {
        display:none;
        border-bottom:1px solid #d5d5d5;
    }
    #bg-settings div.am-row {
        border-bottom: none;
    }
-->
</style>
CUT
        );

        $l_settings = Am_Html::escape(___('Settings'));

        $form->addHtml()
            ->setLabel(___('Layout Background'))
            ->setHtml(<<<CUT
<a href="javascript:;" class="link local link-toggle"
    onclick="jQuery('#bg-settings').toggle(); jQuery(this).closest('.am-row').toggleClass('am-row-head'); jQuery(this).toggleClass('link-toggle-on');">{$l_settings}</a>
CUT
            );

        $form->addRaw()
            ->setContent(<<<CUT
                <div id="bg-settings">
CUT
                );

        $this->addElementColor($form, 'color', "Background Color\n" .
                'you can use any valid <a href="http://www.w3schools.com/html/html_colors.asp" class="link" target="_blank" rel="noreferrer">HTML color</a>, you can find useful color palette <a href="http://www.w3schools.com/TAGS/ref_colornames.asp" class="link" target="_blank" rel="noreferrer">here</a>', 'theme-color', array('class' => 'am-row-highlight'));

        $form->addUpload('bg_img', array('class' => 'am-row-highlight'), array('prefix' => 'theme-default'))
                ->setLabel(___("Backgroud Image"))->default = '';

        $form->addAdvRadio("bg_size", array('class' => 'am-row-highlight'))
            ->setLabel(___("Background Size"))
            ->loadOptions(array(
                'auto' => 'As Is',
                '100%' => '100% Width',
                'cover' => 'Cover',
                'contain' => 'Contain'
            ));

        $form->addAdvRadio("bg_attachment", array('class' => 'am-row-highlight'))
            ->setLabel(___("Background Attachment"))
            ->loadOptions(array(
                'scroll' => 'Scroll',
                'fixed' => 'Fixed',
            ));

        $form->addAdvRadio("bg_repeat", array('class' => 'am-row-highlight'))
            ->setLabel(___("Background Repeat"))
            ->loadOptions(array(
                'no-repeat' => 'No Repeat',
                'repeat' => 'Repeat',
                'repeat-x' => 'Repeat X',
                'repeat-y' => 'Repeat Y',
            ));

        $form->addRaw()
            ->setContent('</div>');
    }

    function addElementColor($form, $name, $label, $id = null, $attr = array())
    {
        $gr = $form->addGroup(null, $attr)
            ->setLabel($label);
        $gr->setSeparator(' ');

        $attr = array('size' => 7, 'class' => 'color-input');
        if ($id) {
            $attr['id'] = $id;
        }

        $gr->addText($name, $attr)
            ->addRule('regex', ___('Color should be in hex representation'), '/#[0-9a-f]{6}/i');

        foreach (array('#f1f5f9', '#dee7ec', '#ffebcd', '#ff8a80', '#ea80fc',
            '#d1c4e9', '#e3f2fd', '#bbdefb', '#0079d1', '#b2dfdb', '#e6ee9c',
            '#c8e6c9', '#4caf50', '#bcaaa4', '#212121', '#263238', '#2a333c') as $color) {
            $gr->addHtml()
                ->setHtml("<div class='color-pick' style='background:{$color}' data-color='$color'></div>");
        }
    }

    function printLayoutHead(Am_View $view)
    {
        if ($this->getConfig('font_family') == self::F_ROBOTO) {
            $view->headLink()->appendStylesheet('https://fonts.googleapis.com/css?family=Roboto');
        }
        if ($this->getConfig('font_family') == self::F_POPPINS) {
            $view->headLink()->appendStylesheet('https://fonts.googleapis.com/css?family=Poppins:300');
        }
        if ($this->getConfig('font_family') == self::F_OXYGEN) {
            $view->headLink()->appendStylesheet('https://fonts.googleapis.com/css?family=Oxygen');
        }
        if ($this->getConfig('font_family') == self::F_HIND) {
            $view->headLink()->appendStylesheet('https://fonts.googleapis.com/css?family=Hind');
        }
        if ($this->getConfig('font_family') == self::F_RAJDHANI) {
            $view->headLink()->appendStylesheet('https://fonts.googleapis.com/css?family=Rajdhani');
        }
        if ($this->getConfig('font_family') == self::F_NUNITO) {
            $view->headLink()->appendStylesheet('https://fonts.googleapis.com/css?family=Nunito');
        }
        if ($this->getConfig('font_family') == self::F_RALEWAY) {
            $view->headLink()->appendStylesheet('https://fonts.googleapis.com/css?family=Raleway');
        }
        $_ = $this->getConfig('version');
        if (file_exists("{$this->getDi()->public_dir}/{$this->getId()}/theme.css")) {
            $view->headLink()
                ->appendStylesheet($this->getDi()->url("data/public/{$this->getId()}/theme.css", strval($_), false));
        } else {
            $view->headLink()
                ->appendStylesheet($this->urlPublicWithVars("css/theme.css" . ($_ ? "?$_" : "")));
        }

        if ($css = $this->getConfig('css')) {
            $view->headStyle()->appendStyle($css);
        }
        if ($this->getConfig('menu_dashboard') == 'text') {
            $view->headStyle()->appendStyle(<<<CUT
ul.am-tabs #menu-member {
    text-indent:0;
    background: none;
    width: auto;
}

ul.am-tabs li.active #menu-member,
ul.am-tabs #menu-member:hover {
    background-image: none;
}
CUT
            );
        }

        if (!$view->di->auth->getUser() && $_ = $this->getConfig('body_finish_out')) {
            $view->placeholder('body-finish')->append($_);
        }
        if ($view->di->auth->getUser() && $_ = $this->getConfig('body_finish_in')) {
            $tmpl = new Am_SimpleTemplate();
            $tmpl->assign('user', $view->di->auth->getUser());

            $view->placeholder('body-finish')->append($tmpl->render($_));
        }
    }

    function getFontOptions()
    {
        return array(
            self::F_TAHOMA => 'Tahoma',
            self::F_ARIAL => 'Arial',
            self::F_TIMES => 'Times',
            self::F_HELVETICA => 'Helvetica',
            self::F_GEORGIA => 'Georgia',
            self::F_ROBOTO => 'Roboto',
            self::F_POPPINS => 'Poppins',
            self::F_OXYGEN => 'Oxygen',
            self::F_HIND => 'Hind',
            self::F_RAJDHANI => 'Rajdhani',
            self::F_NUNITO => 'Nunito',
            self::F_RALEWAY => 'Releway',
        );
    }

    function moveBgFile(Am_Config $before, Am_Config $after)
    {
        $this->moveFile($before, $after, 'bg_img', 'bg_path');
    }

    function moveHeaderBgFile(Am_Config $before, Am_Config $after)
    {
        $this->moveFile($before, $after, 'header_bg_img', 'header_bg_path');
    }

    public function updateVersion(Am_Config $before, Am_Config $after)
    {
        $t = "themes.{$this->getId()}.version";
        $_ = $after->get($t);
        $after->set($t, ++$_);
    }

    public function normalize(Am_Config $before, Am_Config $after)
    {
        $t = "themes.{$this->getId()}.border_radius";
        $after->set($t, (int)$after->get($t));
    }

    public function updateShadow(Am_Config $before, Am_Config $after)
    {
        $t_id = "themes.{$this->getId()}.drop_shadow";
        $t_new = "themes.{$this->getId()}.content_shadow";

        $after->set($t_new, $after->get($t_id) ? self::SHADOW : 'none');

        $tt_id = "themes.{$this->getId()}.login_bg";
        $tt_new = "themes.{$this->getId()}.login_shadow";

        $after->set($tt_new, ($after->get($t_id) && $after->get($tt_id) == 'white') ? self::SHADOW : 'none');

        $ttt_new = "themes.{$this->getId()}.login_bg_color";

        $after->set($ttt_new, ($after->get($tt_id) == 'white') ? 'white' : 'none');
    }

    public function updateBg(Am_Config $before, Am_Config $after)
    {
        $t_id = "themes.{$this->getId()}.bg_path";
        $t_new = "themes.{$this->getId()}.bg";
        $t_color = "themes.{$this->getId()}.color";
        $t_repeat = "themes.{$this->getId()}.bg_repeat";

        $url = $this->getDi()->url("data/public/{$after->get($t_id)}", false);

        $after->set($t_new, $after->get($t_id) ?
            "url('{$url}') {$after->get($t_color)} top center {$after->get($t_repeat)};" :
            $after->get($t_color));
    }

    public function updateHeaderBg(Am_Config $before, Am_Config $after)
    {
        $t_id = "themes.{$this->getId()}.header_bg_path";
        $t_color = "themes.{$this->getId()}.header_bg_color";
        $t_theme_color = "themes.{$this->getId()}.color";

        $t_repeat = "themes.{$this->getId()}.header_bg_repeat";
        $t_new = "themes.{$this->getId()}.header_bg";

        $url = $this->getDi()->url("data/public/{$after->get($t_id)}", false);

        $after->set($t_new, $after->get($t_id) ?
            "url('{$url}') {$after->get($t_color)} top center {$after->get($t_repeat)};" :
            ($after->get($t_color) ?: 'none'));
    }

    public function updateFile(Am_Config $before, Am_Config $after)
    {
        $this->config = $after->get("themes.{$this->getId()}") + $this->getDefaults();

        $css = $this->parsePublicWithVars('css/theme.css');
        $filename = "{$this->getDi()->public_dir}/{$this->getId()}/theme.css";
        mkdir(dirname($filename), 0755, true);
        file_put_contents($filename, $css);
    }

    public function findInverseColor(Am_Config $before, Am_Config $after)
    {
        $t_id = "themes.{$this->getId()}.color";
        $t_new = "themes.{$this->getId()}.color_c";
        $after->set($t_new, $this->inverse($after->get($t_id)));
    }

    public function findDarkenColor(Am_Config $before, Am_Config $after)
    {
        $t_id = "themes.{$this->getId()}.color";
        $t_new = "themes.{$this->getId()}.color_d";
        $after->set($t_new, $this->brightness($after->get($t_id), -50));
    }

    protected function inverse($color)
    {
        if ($color[0] != '#') return '#ffffff';

        $color = str_replace('#', '', $color);
        if (strlen($color) == 3) {
            $color = str_repeat(substr($color,0,1), 2).str_repeat(substr($color,1,1), 2).str_repeat(substr($color,2,1), 2);
        }
        $rgb = '';
        for ($x=0; $x<3; $x++){
            $c = 255 - hexdec(substr($color,(2*$x),2));
            $c = ($c < 0) ? 0 : dechex($c);
            $rgb .= (strlen($c) < 2) ? '0'.$c : $c;
        }
        return '#'.$rgb;
    }

    protected function brightness($color, $steps)
    {
        if ($color[0] != '#') return $color;

        $steps = max(-255, min(255, $steps));

        $color = str_replace('#', '', $color);
        if (strlen($color) == 3) {
            $color = str_repeat(substr($color,0,1), 2).str_repeat(substr($color,1,1), 2).str_repeat(substr($color,2,1), 2);
        }
        $rgb = '';
        for ($x=0; $x<3; $x++){
            $c = max(0, min(255, hexdec(substr($color,(2*$x),2)) + $steps));
            $c = dechex($c);
            $rgb .= (strlen($c) < 2) ? '0'.$c : $c;
        }
        return '#'.$rgb;
    }

    public function getDefaults()
    {
        return parent::getDefaults() + array(
            'color' => '#f1f5f9',
            'link_color'=> '#3f7fb0',
            'color_c' => '#0e0a06',
            'color_d' => '#bfc3c7',
            'logo_align' => 'left',
            'max_width' => 900,
            'logo_width' => 'auto',
            'font_size' => 13,
            'font_family' => self::F_ARIAL,
            'drop_shadow' => 1,
            'content_shadow' => self::SHADOW,
            'version' => '',
            'border_radius' => 0,
            'bg_size' => 'auto',
            'bg_attachment' => 'scroll',
            'bg_repeat' => 'no-repeat',
            'login_layout' => 'layout.phtml',
            'login_bg' => 'none',
            'header_bg_color' => '',
            'header_bg_size' => 'cover',
            'header_bg_repeat' => 'no-repeat',
            'menu_color' => '#eb6653',
            'menu_dashboard' => 'icon',
        );
    }
}