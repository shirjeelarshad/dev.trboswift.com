<?php
   /*
   Template Name: Car Loan Calculator
    
   * Theme: TURBOBID CORE FRAMEWORK FILE
   * Url: www.turbobid.ca
   * Author: Md Nuralam
   *
   * THIS FILE WILL BE UPDATED WITH EVERY UPDATE
   * IF YOU WANT TO MODIFY THIS FILE, CREATE A CHILD THEME
   *
   * http://codex.wordpress.org/Child_Themes
   */
   
   

   
   ?>
   
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, width=device-width" />

	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/framework/css/car-loan/global.css" />
    
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/framework/css/car-loan/index.css" />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700&display=swap"
    />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Open Sans:wght@400&display=swap"
    />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,200;0,400;0,500;0,600;0,700;0,800;1,400&display=swap"
    />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Plus Jakarta Sans:wght@400;600;700&display=swap"
    />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap"
    />
  </head>
  <body>
   <div class="loan-calculator">
    <div class="background-parent">
        <div class="background2">
            <div class="calculator-container">
                <div class="calculator-title-container">
                    <h1 class="car-loan-calculator">Car loan calculator</h1>
                    <div class="calculator-description-contain">
                        <div class="easily-estimate-your">
                            Easily estimate your budget for your dream car
                        </div>
                    </div>
                </div>
            </div>
            <div class="calculator-form">
                <div class="backgroundbordershadow">
                    <div class="price-input">
                        <div class="price-field">
                            <div class="price-input-wrapper">
                                <div class="vehicle-price">Vehicle price</div>
                            </div>
                            <div class="backgroundborder">
                                <div class="payment-calculation">$</div>
                                <input type="number" id="vehicle-price" class="empty-payment" value="30000">
                            </div>
                        </div>
                        <div class="payment-calculation-input">
                            <input type="range" id="vehicle-price-slider" min="0" max="100000" value="30000" style="width: 100%;">
                        </div>
                    </div>
                    <div class="down-payment-input-parent">
                        <div class="down-payment-input">
                            <div class="down-payment">Down payment</div>
                            <div class="optional">Optional</div>
                        </div>
                        <div class="backgroundborder1">
                            <div class="down-payment-top">$</div>
                            <input type="number" id="down-payment" class="down-payment-bottom" value="0">
                        </div>
                    </div>
                    <div class="other-options-input-parent">
                        <div class="other-options-input">
                        <!--
                            <div class="trade-in-value-parent">
                                <div class="trade-in-value">Trade-in value</div>
                                <div class="optional1">Optional</div>
                            </div> -->
                            <div class="term-length-container">
                                <div class="term-length">Term length</div>
                            </div>
                            <div class="credit-score">Credit score</div>
                        </div>
                        <div class="other-options-border">
                        <!--
                            <div class="backgroundborder2">
                                <div class="trade-border-top">$</div>
                                <input type="number" id="trade-in-value" class="trade-border-bottom" value="0">
                            </div> -->
                            <div class="backgroundborder3">
                                <select id="term-length" class="months">
                                    <option value="24">24 months</option>
                                    <option value="36">36 months</option>
                                    <option value="48">48 months</option>
                                    <option value="60">60 months</option>
                                    <option value="72" selected>72 months</option>
                                    <option value="84">84 months</option>
                                    <option value="96">96 months</option>
                                </select>
                            </div>
                            <div class="backgroundborder4">
                                <select id="credit-score" class="credit-border-top">
                                    <option value="<600"><600</option>
                                    <option value="601-680">601 - 680</option>
                                    <option value="681-780">681 - 780</option>
                                    <option value="780+">780+</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="backgroundbordershadow2">
                    <div class="backgroundbordershadow-inner">
                        <div class="frame-parent">
                            <div class="background-group">
                                <div class="background5">
                                    <div class="container1">
                                        <button class="tab" id="biweekly-tab">
                                            <div class="background6 background-white">Biweekly</div>
                                        </button>
                                        <button class="tab1" id="monthly-tab">
                                            <div class="monthly">Monthly</div>
                                        </button>
                                    </div>
                                </div>
                                <div class="biweekly-payment-container">
                                    <div class="your-estimated-payment" id="payment-title">
                                        Your estimated biweekly payment
                                    </div>
                                </div>
                            </div>
                            <div class="wrapper">
                                <b class="b" id="estimated-payment">$298</b>
                            </div>
                        </div>
                    </div>
                    <div class="apr-estimated-based-on-your-c-wrapper">
                        <div class="apr-estimated-based" id="apr-estimate">
                            8.99% APR (estimated based on your credit score)
                        </div>
                    </div>
                    <div class="backgroundhorizontalborder">
                        <div class="personalize-your-financing-ter-wrapper">
                            <div class="personalize-your-financing">
                                Personalize your financing terms in minutes,
                            </div>
                        </div>
                        <div class="credit-info">
                            <div class="with-no-impact-to-your-credit-wrapper">
                                <div class="with-no-impact-container">
                                    <span>with </span>
                                    <span class="no-impact-to">no impact to your credit score.</span>
                                </div>
                            </div>
                            <a href="<?php echo home_url(); ?>/finance/" class="button">
                                <b class="get-pre-qualified">Get pre-qualified</b>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Other content -->
    </div>
</div>

 <script>
 jQuery(document).ready(function ($) {
    // Initial values
    let vehiclePrice = 30000;
    let downPayment = 0;
    // let tradeInValue = 0;
    let termLength = 72;
    let creditScore = '780+';
    let apr = 8.99;
    let isBiweekly = true;

    function calculatePayment() {
        const loanAmount = vehiclePrice - downPayment;
        const monthlyInterestRate = (apr / 100) / 12;
        const numberOfPayments = termLength;

        const monthlyPayment = (loanAmount * monthlyInterestRate) / (1 - Math.pow(1 + monthlyInterestRate, -numberOfPayments));
        const biweeklyPayment = monthlyPayment / 2;

        if (isBiweekly) {
            $('#estimated-payment').text(`$${biweeklyPayment.toFixed(2)}`);
        } else {
            $('#estimated-payment').text(`$${monthlyPayment.toFixed(2)}`);
        }

        $('#apr-estimate').text(`${apr}% APR (estimated based on your credit score)`);
    }

    function updateApr() {
        switch (creditScore) {
            case '<600':
                apr = 10.49;
                break;
            case '601-680':
                apr = 9.99;
                break;
            case '681-780':
                apr = 9.49;
                break;
            case '780+':
                apr = 8.99;
                break;
        }
        calculatePayment();
    }

    $('#vehicle-price, #down-payment, #term-length, #credit-score').on('input change', function () {
        vehiclePrice = parseFloat($('#vehicle-price').val());
        downPayment = parseFloat($('#down-payment').val());
        // tradeInValue = parseFloat($('#trade-in-value').val());
        termLength = parseInt($('#term-length').val());
        creditScore = $('#credit-score').val();

        updateApr();
    });

    $('#vehicle-price-slider').on('input', function () {
        $('#vehicle-price').val(this.value).trigger('input');
    });

    $('#biweekly-tab').click(function () {
        isBiweekly = true;
        $('#payment-title').text('Your estimated biweekly payment');
        $('.background6').addClass('background-white');
        $('.monthly').removeClass('background-white');
        calculatePayment();
    });

    $('#monthly-tab').click(function () {
        isBiweekly = false;
        $('#payment-title').text('Your estimated monthly payment');
        $('.monthly').addClass('background-white');
        $('.background6').removeClass('background-white');
        calculatePayment();
    });

    // Initial calculation
    calculatePayment();
});

 
 </script>
 <style>
 input#vehicle-price, input#down-payment, input#trade-in-value, select#term-length, select#credit-score {
border: none !important;
}
 </style>
  </body>
</html>