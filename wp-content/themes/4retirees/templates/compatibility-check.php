<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#compatability-check-modal">
    Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="compatability-check-modal" tabindex="-1" role="dialog" aria-labelledby="compatability-check-heading" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-strip"></div>
            <div class="modal-header">
                <img class="modal-close" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/modal-close.png'; ?>"  data-dismiss="modal" alt="Close" title="Close"/>
                <h5 class="modal-title" id="compatability-check-heading">
                    Your <span>FREE</span> Income Compatibility Check
                </h5>
            </div>
            <div class="modal-body modal-hideable">

                <div class="question"></div>

                <div class="question-progress">
                    <div class="question-progress-advanced"></div>
                </div>

                <div class="question-actions">
                    <div class="row">
                        <div class="col">
                            <button type="button" class="btn btn-green action-left">YES</button>
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-orange action-right">NO</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer modal-hideable">
                <button type="button" class="btn btn-purlple action-back"><i class="fa fa-angle-left"></i> BACK</button>
                <div class="questions-progress">QUESTION <span></span> OF <?php echo count(cc_data()); ?></div>
                <button type="button" class="btn btn-yellow action-next">NEXT <i class="fa fa-angle-right"></i></button>
            </div>

            <!-- CHECK COMPLETE -->
            <div class="check-screen check-complete">
                <div class="inner">

                    <div class="check-inner-intro">
                        <i class="fa fa-check-circle"></i>
                        <h6>COMPATIBILITY CHECK COMPLETE</h6>
                        <p>Results will be sent to your email address now, please enter your details below:</p>
                    </div>

                     <form id="get-results" action="">
                         <div class="form-group">
                            <input type="text" name="form_first_name" placeholder="First Name" class="form-control">
                         </div>
                         <div class="form-group">
                            <input type="text" name="form_last_name" placeholder="Surname" class="form-control">
                         </div>
                         <div class="form-group">
                            <input type="email" name="form_email" placeholder="Email Address" class="form-control">
                         </div>
                         <div class="form-group">
                            <input type="number" name="form_age" placeholder="Age" class="form-control">
                         </div>
                         <div class="form-group form-check">
                            <input type="checkbox" name="form_accept_marketing" class="form-check-input" id="exampleCheck2">
                             <label class="form-check-label" for="exampleCheck2">Stay up to date with our latest Articles and Opportunities through our Newsletters.
                             </label>
                         </div>
                         <div class="form-group form-check">
                            <input type="checkbox" name="form_accept_terms" class="form-check-input" id="exampleCheck1">
                             <label class="form-check-label" for="exampleCheck1">I agree to 4Retirees <a href="<?php echo home_url('terms'); ?>" target="_blank">Terms & Conditions</a> and acknowledge I've read the <a href="<?php echo home_url('terms'); ?>" target="_blank">Privacy Policy</a>.
                             </label>
                         </div>
                         <div class="form-group">
                             <?php wp_nonce_field('cc_get_results_action', 'cc_get_results_nonce'); ?>
                            <button type="submit" class="btn btn-orange">GET YOUR RESULTS NOW</button>
                         </div>
                     </form>
                </div>
            </div>
             <!-- CHECK COMPLETE -->

            <div class="check-screen check-noop">
                <div class="inner">

                    <div class="check-inner-intro">
                        <h6>SORRY, NO MATCHES FOUND
                        </h6>
                        <p>Well done on taking the Free Income Compatibility Check.</p>
                    </div>

                    <div class="check-inner-text">
                        <p>We wish we had better news to pass along. Unfortunately, given your answers and your current circumstances, there are no appropriate matches for you with the current on-demand economy business opportunities available.</p>
                        <p>It’s a fair bet that opportunities will become available for you sometime soon. Definitely come back and <a href="#" class="retake-check">take the Free Income Compatibility Check again</a>.</p>
                        <p>For now, there are lots of benefits here in the 4Retirees community. Enjoy them. We have created an account for you so that you have access. Please check your email to activate your member account.</p>
                        <p class="text-italic">If you haven’t received an email within 20min, please let us know at <a href="mailto:hello@4retirees.com">hello@4retirees.com</a> so we can manually send your results.</p>
                    </div>

                    <div class="check-share">
                        <div class="inner">
                            <div class="text">Do you have friends or family who would like to earn extra income? Share the <span>FREE</span> Income Compatibility Check now:</div>
                            <div class="check-share-icons">
                                <div class="row">
                                    <div class="col col-share">SHARE:</div>
                                    <div class="col">
                                        <div class="shell one">
                                            <i class="fa fa-facebook-f"></i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="shell two">
                                            <i class="fa fa-twitter"></i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="shell three">
                                            <i class="fa fa-instagram"></i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="shell four">
                                            <i class="fa fa-linkedin"></i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="shell five">
                                            <i class="fa fa-envelope"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="check-screen check-buy">
                <div class="inner">

                    <div class="check-inner-intro">
                        <h6>CONGRATULATIONS!</h6>
                        <p>Well done on taking the Free Income Compatibility Check.</p>
                    </div>

                    <div class="check-inner-text">
                        <p>It all begins here! Welcome to your fast track to freedom. Now’s your chance to take your adventures off hold and rediscover your life.</p>

                        <div class="row">
                            <div class="col results-left-top">
                                YOU HAVE BEEN MATCHED TO:
                            </div>
                            <div class="col results-right-top">
                                ESTIMATED EARNING POTENTIAL:
                            </div>
                        </div>
                        <div class="results">
                            <div class="row">
                                <div class="col results-left">
                                    <div class="col count-row">
                                        <table>
                                            <tr>
                                                <td class="count-left"><span class="count">0</span></td>
                                                <td class="count-right"><span class="">On-demand economy businesses</span></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="col results-right">
                                    <div class="col estimate-row">
                                        <table>
                                            <tr>
                                                <td><span class="estimated">0</span> <span>/month</span></td>
                                            </tr>
                                        </table>
                                    </div>

<!--                                    <span class="estimated"></span> <span>/month</span>-->
                                </div>
                            </div>
                        </div>

                        <p>You have been matched with <span class="text-700"><span class="target-count">0</span> on-demand economy businesses in Australia</span>. The estimated value you can earn is approximately <span class="text-700">$<span class="target-amount">0</span> per month</span>.
                        </p>
                        <p><a class="text-orange text-underline" href="<?php echo home_url(); ?>">CLICK HERE</a> to purchase your personalised <span class="text-700">On-Demand Opportunities List</span>
                        </p>

                        <a class="buy-now btn btn-orange" href="<?php echo home_url(); ?>"><i class="fa fa-shopping-cart"></i> BUY NOW (<span>$199</span> $149)</a>

                        <div><img class="modal-payment-icons" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/modal-payment-icons.png'; ?>"/></div>
                        <p class="text-italic">We have sent a copy of the results above to your email. If you haven’t received an email within 20min, please let us know at <a href="mailto:hello@4retirees.com">hello@4retirees.com</a> so we can manually send your results.
                            </p>
                    </div>

                    <div class="check-share">
                        <div class="inner">
                            <div class="text">Do you have friends or family who would like to earn extra income? Share the <span>FREE</span> Income Compatibility Check now:</div>
                            <div class="check-share-icons">
                                <div class="row">
                                    <div class="col col-share">SHARE:</div>
                                    <div class="col">
                                        <div class="shell one">
                                            <i class="fa fa-facebook-f"></i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="shell two">
                                            <i class="fa fa-twitter"></i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="shell three">
                                            <i class="fa fa-instagram"></i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="shell four">
                                            <i class="fa fa-linkedin"></i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="shell five">
                                            <i class="fa fa-envelope"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>