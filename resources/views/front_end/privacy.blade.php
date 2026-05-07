@extends('layouts.frontend')
@section('title', 'Privacy Policy')
<link rel="stylesheet" type="text/css" href="{{ asset('login/animate.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('login/main.css')}}">
@section('content')
@if(Session::has('message'))
    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
@endif

<section class="section contenz">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="contz">
                    <h3> Privacy Policy </h3>
                    <p>By registering as a user of the services provided by us and by using this website, you are agreeing to the following: </p>
                    <p>1. When you register and use this site you will be asked to provide certain information such as your contact details. We will store this data and hold it on computers or otherwise. We will use this data to fulfill our agreement with you. </p>
                    <p>2. We may use information you provide or is obtained by us: </p>
                    <p>(a) To register you with our web site and to administer our web site services; </p>
                    <p>(b) For assessment and analysis (e.g. market, customer and product analysis) to enable us to review, develop and improve the services which we offer and to enable us to provide you and other customers with relevant information through our marketing programme. We may use your information to make decisions about you using computerized technology, for example, automatically selecting products or services, which we think will interest you from the information we have. We may inform you (by e-mail, mail or otherwise) about products and services which we consider may be of interest to you. </p>
                    <p> (c) For the prevention and detection of fraud. </p>
                    <p> 3. We may give information about you to the following, who may use it for the same purposes as set out above: </p>
                    <p> (a) To employees and agents of us to administer any accounts, products and services provided to you by us now or in the future. </p>
                    <p>(b) Agents who profile your data so that we may tailor the goods/services we offer to your specific needs </p>
                    <p> 4. We may also disclose your information: </p>
                    <p> (a) To anyone to whom we transfer or may transfer our rights and duties under our agreement with you.</p>
                    <p>(b) If we have a duty to do so or if the law allows us to do so. </p>
                    <p> 5. In order to ensure that we can monitor and improve the site, we may gather certain information about you when you use it, including details of your domain name and IP address, operating system, browser version and the web site you visited prior to our site.</p>
                    <p> 6. We use “cookies” to help us improve and customize our web site. A cookie is an element of data that a web site can send to your browser, which may then store it on your system. Cookies allow us to understand who has seen which pages and advertisements, to determine how frequently particular pages are visited and to determine the most popular areas of our web site. Cookies also allow us to make our web site more user friendly by, for example, allowing us to save your password so that you do not have to re-enter it every time you visit our web site. We use cookies so that we can give you a better experience when you return to our web site. Most web browsers automatically accept cookies. You do not have to accept cookies, and you should read the information that came with your browser software to see how you can set up your browser to notify you when you receive a cookie. This will give you the opportunity to decide whether to accept it.</p>
                    <p> 7. We may supplement the information you provide to us with information we receive from third parties.</p>
                    <p> 8. We endeavor to take all reasonable steps to protect your personal details. However, we cannot guarantee the security of any data you disclose online. You accept the inherent security risks of providing information and dealing online over the Internet and will not hold us responsible for any breach of security unless this is due to our negligence or willful default. </p>
                    <p>9. You have the right to see personal data (as defined in the Data Protection Act) we keep about you, upon receipt of a written request and payment of a fee. If you are concerned that any of the information we hold on you is incorrect please contact us. </p>
                    <p>Please reach out to us on 02038429314 for any clarifications on any points. </p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() { 
        $('p.alert').delay(2000).slideUp(300); 
    });
</script>
@endsection
