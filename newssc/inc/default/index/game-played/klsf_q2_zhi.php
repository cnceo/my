<?php
echo '<input type="hidden" name="playedGroup" value="';echo $this->groupId;echo '" />
<input type="hidden" name="playedId" value="';echo $this->played;echo '" />
<input type="hidden" name="type" value="';echo $this->type;echo '" />
	';foreach(array('第一','第二') as $var){;echo '    <div class="pp pp11" action="tzAllSelect" length="2" delimiter=" ">
        <div class="title">';echo $var;echo '位</div>
        <input type="button" value="01" class="code d min" />
        <input type="button" value="02" class="code s min" />
        <input type="button" value="03" class="code d min" />
        <input type="button" value="04" class="code s min" />
        <input type="button" value="05" class="code d min" />
        <input type="button" value="06" class="code s min" />
        <input type="button" value="07" class="code d min" />
        <input type="button" value="08" class="code s min" />
        <input type="button" value="09" class="code d min" />
        <input type="button" value="10" class="code s min" /><br>
        <input type="button" value="11" class="code d max" />
        <input type="button" value="12" class="code s max" />
        <input type="button" value="13" class="code d max" />
        <input type="button" value="14" class="code s max" />
        <input type="button" value="15" class="code d max" />
        <input type="button" value="16" class="code s max" />
        <input type="button" value="17" class="code d max" />
        <input type="button" value="18" class="code s max" />
        <input type="button" value="19" class="code d max" />
        <input type="button" value="20" class="code s max" />
        <input type="button" value="全" class="action all" />
        <input type="button" value="大" class="action large" />
        <input type="button" value="小" class="action small" />
        <input type="button" value="单" class="action odd" />
        <input type="button" value="双" class="action even" />
        <input type="button" value="清" class="action none" />
    </div>
';
}
$maxPl=$this->getPl($this->type,$this->played);
;echo '
<script type="text/javascript">
$(function(){
	gameSetPl(';echo json_encode($maxPl);echo ');
})
</script>

'
?>