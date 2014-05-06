<div class="answer col-sm-4">
    <div class="answer-inner">
        <div class="group bar heading <%= gender %>">
            <div class="gender" data-toggle="tooltip" data-placement="top" title="<%= localizedGender %>">
                <% if(gender == "male") {%>
                <i class="fa fa-male"></i>
                <%}%>
                <% if(gender == "female") {%>
                <i class="fa fa-female"></i>
                <%}%>
            </div>
            <div class="time">
                <%= timeago %>
            </div>
            <div class="age <%= ageClass %>" data-placement="top" title="<%= age %> <?php echo Yii::t('report', 'years'); ?>">
                <% if(age) {%>
                <%= age %>
                <%}%>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="survey group box" data-placement="top" title="<?php echo Yii::t('report', 'site'); ?>">
            <%= survey %>
        </div>
        <div class="group box" data-placement="top" title="<?php echo Yii::t('report', 'visit motive'); ?>">
            <p class="motive">
                <%= motive %>
            </p>
        </div>
        <% if(failure_text) {%>
        <div class="group box <%= sentimentClass %>" data-placement="top" title="<?php echo Yii::t('report', 'failure reason'); ?>">
            <i class="fa fa-exclamation failure-sign"></i>
            <p class="failure-text">
                <%= failure_text %>
            </p>
        </div>
        <%}%>
        <% if(feedback) {%>
        <div class="group box <%= sentimentClass %>" data-placement="top" title="<?php echo Yii::t('report', 'open feedback'); ?>">
            <p class="feedback">
                <%= feedback %>
            </p>
        </div>
        <%}%>

        <div class="group box last row">
            <% if(recommend) {%>
            <div class="recommend col-xs-6">
                <div>
                    <?php echo Yii::t('report', 'recommend'); ?>
                </div>
                <div class="simple-bar-chart" data-placement="top" title="<%= recommend %> / 10">
                    <div class="number-wrapper">
                        <div class="number"><%= recommend %></div>
                    </div>
                    <div class="filled-bar <%= recommendColor %>" style="width: <%= recommend / 10 * 100 %>%"></div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <%}%>
            <% if(interest) {%>
            <div class="interest col-xs-6">
                <div>
                    <?php echo Yii::t('report', 'interest'); ?>
                </div>
                <div class="simple-bar-chart" data-placement="top" title="<%= interest %> / 6">
                    <div class="number-wrapper">
                        <div class="number"><%= interest %></div>
                    </div>
                    <div class="filled-bar <%= interestColor %>" style="width: <%= interest / 6 * 100 %>%"></div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <%}%>
            <div class="clearfix"></div>
        </div>


    </div>
</div>
