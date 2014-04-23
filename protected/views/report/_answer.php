<div class="answer col-sm-4">
    <div class="answer-inner">
        <div class="group bar heading <%= gender %>">
            <div class="gender">
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
            <div class="age <%= ageClass %>">
                <% if(age) {%>
                <%= age %>
                <%}%>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="survey bar group box">
            <%= survey %>
        </div>
        <div class="group box">
            <p class="motive">
                <%= motive %>
            </p>
        </div>
        <% if(failure_text) {%>
        <div class="group box">
            <p class="failure-text">
                <%= failure_text %>
            </p>
        </div>
        <%}%>
        <% if(feedback) {%>
        <div class="group box <%= sentimentClass %>">
            <p class="feedback">
                <%= feedback %>
            </p>
        </div>
        <%}%>
        <% if(recommend) {%>
        <div class="group box">
            <div class="recommend">
                <div>
                    <?php echo Yii::t('report', 'NPS'); ?>
                </div>
                <div class="simple-bar-chart">
                    <div class="number"><%= recommend %></div>
                    <div class="filled-bar <%= recommendColor %>" style="width: <%= recommend / 10 * 100 %>%"></div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <%}%>
        <% if(interest) {%>
        <div class="group box">
            <div class="interest">
                <div>
                    <?php echo Yii::t('report', 'interest'); ?>
                </div>
                <div class="simple-bar-chart">
                    <div class="number"><%= interest %></div>
                    <div class="filled-bar <%= interestColor %>" style="width: <%= interest / 6 * 100 %>%"></div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <%}%>
    </div>
</div>
