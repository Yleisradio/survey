<div class="answer col-sm-4">\
    <div class="well <%= group %>">\
        <div class="row">\
            <div class="col-md-9">\
                <% if(gender) {%>\
                <%= localizedGender %>\
                <%}%>\
                <% if(age) {%>\
                <%= age %>\
                <?php echo Yii::t('report', 'answer.age'); ?>\
                <%}%>\
            </div>\
            <% if(gender) {%>\
            <img class="col-md-3" src="images/icon-<%= gender %>.png">\
            <%}%>\
        </div>\
        <div class="">\
            <%= timeago %>\
        </div>\
        <div class="">\
            <%= survey %>\
        </div>\
        <div class="">\
            <%= motive %>\
        </div>\
        <div class="row">\
            <div class="col-md-4">\
                <%= localizedNPSGroup %>\
            </div>\
        </div>\
        <% if(failure_text) {%>\
        <?php echo Yii::t('report', 'answer.failure_text'); ?>\
        <div class="failure-text">\
            <span class=""><%= failure_text %></span>\
        </div>\
        <%}%>\
        <% if(feedback) {%>\
        <?php echo Yii::t('report', 'answer.feedback'); ?>\
        <div class="feedback">\
            <span class=""><%= feedback %></span>\
        </div>\
        <%}%>\
    </div>\
</div>\
