<div class="slide-out-div hidden-phone">
    <a class="handle" href="#"></a>

    <div class="form-header-message">
        <h3>Got a Problem?</h3>

        <div class="header-message-disc">
            <a href="/customer-care" target="_blank">
                <button>Contact Support</button>
            </a>

            <div class="top-spacer">
                For <b>buying assistance</b> or any other <b>order related</b> query, kindly get in touch with our
                support team.
            </div>
            <div class="clearer">
                &nbsp;</div>
        </div>
        <hr class="hr-break">
        <h3>
            Tell us what you think.</h3>

        <p>
            Love us / have suggestions / ideas / feature requests? Tell us how we can improve our website.</p>
    </div>
    <div class="feedback-success" style="display: none" id="feedback-success-message">Thank you for giving us the feedback</div>
    <form name="feedbackForm" id="feedbackForm" method="post">
        <fieldset>
            <div class="feedback-form-wrapper">
                <ul class="form-list">
                    <li class="li-feedback">
                        <label for="email" class="required"><em>*</em>Email</label>

                        <div class="input-box">
                            <input type="text" name="email" maxlength="255" value="" id="feedback-email"
                                   class="text">
                            <span id="feedback_email_error"></span>
                        </div>
                    </li>

                    <li class="li-feedback">
                        <label for="mobile">Mobile</label>

                        <div class="input-box">
                            <input type="text" name="mobile" maxlength="255" value="" id="feedback-mobile"
                                   class="text">
                        </div>
                    </li>

                    <li class="li-feedback">
                        <label for="category" class="required"><em>*</em>Category</label>

                        <div class="input-box">
                            <select name="category" id="feedbackCategory">
                                <option value="1" selected="selected">Improve this page</option>
                                <option value="2">Suggest new features/ideas</option>
                                <option value="3">Suggest new products/categories</option>
                                <option value="4">Shopping experience</option>
                                <option value="5">Feedback on prices/offers</option>
                                <option value="6">Others -General Feedback</option>
                            </select>
                            <span id="feedback_category_error"></span>
                        </div>
                    </li>
                    <li class="li-feedback">
                        <label for="message" class="required"><em>*</em>Message</label>

                        <div class="input-box">
                            <textarea name="message" id="feedback-message"></textarea>
                            <div id="feedback_message_error"></div>
                        </div>
                    </li>

                    <div id="experienceRadio" style="display: none">
                        <li class="li-feedback">

                            <label for="experienceRadio" class="required"><em>*</em>How would you rate your overall shopping experience on Milagrow
                                Humantech</label>

                            <div class="input-box">
                                <span class="horizontalRadio"><input type="radio" name="experienceRadio" value="love" id="experience"/>Love it</span>
                                <span class="horizontalRadio"><input type="radio" name="experienceRadio" value="good" id="experience"/>Good</span>
                                <span class="horizontalRadio"><input type="radio" name="experienceRadio" value="average" id="experience"/>Average</span>
                                <span class="horizontalRadio"><input type="radio" name="experienceRadio" value="bad" id="experience"/>Bad</span>
                                <div id="feedback_radio_error"></div>
                            </div>
                        </li>
                    </div>

                    <li>
                        <p class="required">*Required Fields</p>
                        <button type="submit" name="submit" class="button">
                            <span><span>Submit</span></span>
                        </button><span id="feedback-ajax-loader" style="display: none"><img src="/modules/feedback/ajax-loader.gif" alt="ajax-loader"></span>
                    </li>


                </ul>
            </div>
        </fieldset>
    </form>
</div>
