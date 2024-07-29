@extends('index')

@section('content')

 <!-- ======= Hero Section ======= -->
 <section id="hero">
    <div class="hero-container" data-aos="zoom-in" data-aos-delay="100">
      <h1>Bienvenue Sur Sunu Lycée </h1>
      <h2>La plateforme de gestion ultime pour votre lycée</h2>
      <h3>Votre lycée est déjà parmi nous. Connectez-vous pour rejoindre dès maintenant vos classes.</h3>
      <a href="{{ route('users.login')}}" class="btn-get-started">Connexions</a>
    </div>
  </section><!-- End Hero Section -->



  <!-- about -->
  <section id="about">
      <div class="container" data-aos="fade-up">
        <div class="row about-container">

          <div class="col-lg-6 content order-lg-1 order-2">
          <h2 class="title">Quelques mots sur nous</h2>
         <p>Nous sommes une plateforme dédiée à la gestion efficace et moderne des lycées. Notre mission est de simplifier les processus administratifs et de favoriser une meilleure communication au sein des établissements scolaires.</p>
         <div class="icon-box" data-aos="fade-up" data-aos-delay="100">
      <div class="icon"><i class="bi bi-briefcase"></i></div>
      <h4 class="title"><a href="">Gestion Administrative</a></h4>
      <p class="description">Simplifiez les tâches administratives quotidiennes avec notre interface intuitive.</p>
    </div>
    <div class="icon-box" data-aos="fade-up" data-aos-delay="200">
      <div class="icon"><i class="bi bi-card-checklist"></i></div>
      <h4 class="title"><a href="">Suivi des Étudiants</a></h4>
      <p class="description">Gardez une trace des performances et du progrès de chaque étudiant facilement.</p>
    </div>
    <div class="icon-box" data-aos="fade-up" data-aos-delay="300">
      <div class="icon"><i class="bi bi-binoculars"></i></div>
      <h4 class="title"><a href="">Communication Efficace</a></h4>
      <p class="description">Facilitez la communication entre les enseignants, les étudiants et les parents.</p>
    </div>
          </div>
          <div class="col-lg-6 background order-lg-2 order-1" data-aos="fade-left" data-aos-delay="100"></div>
        </div>
      </div>
    </section>
   <!-- end about -->

   <!-- action -->
   <section id="call-to-action">
      <div class="container">
        <div class="row" data-aos="zoom-in">
          <div class="col-lg-9 text-center text-lg-start">
            <h3 class="cta-title">Améliorez la Gestion de Votre Lycée</h3>
            <p class="cta-text">Découvrez notre plateforme intuitive pour une gestion efficace et simplifiée de votre établissement scolaire. Optimisez vos processus administratifs dès aujourd'hui.</p>
          </div>
          <div class="col-lg-3 cta-btn-container text-center">
            <a class="cta-btn align-middle" href="{{ route('admin.login')}}"> Commencer !</a>
          </div>
        </div>

      </div>
    </section>
    <!-- end action -->

<!-- contact -->
<section id="contact">
      <div class="container">
        <div class="section-header">
          <h3 class="section-title">Contactez Nous !</h3>
          <p class="section-description">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque</p>
        </div>
      </div>

     
      <div class="container mt-5">
        <div class="row justify-content-center">

          <div class="col-lg-3 col-md-4">

            <div class="info">
              <div>
                <i class="bi bi-geo-alt"></i>
                <p>Dakar<br>Sénégal</p>
              </div>

              <div>
                <i class="bi bi-envelope"></i>
                <p>info@example.com</p>
              </div>

              <div>
                <i class="bi bi-phone"></i>
                <p>+ 221 XX XXX XX XX</p>
              </div>
            </div>

            <div class="social-links">
              <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
              <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
              <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
              <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
              <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
            </div>

          </div>

          <div class="col-lg-5 col-md-8">
            <div class="form">
              <form action="forms/contact.php" method="post" role="form" class="php-email-form">
                <div class="form-group">
                  <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
                </div>
                <div class="form-group mt-3">
                  <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
                </div>
                <div class="form-group mt-3">
                  <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
                </div>
                <div class="form-group mt-3">
                  <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
                </div>
                <div class="my-3">
                  <div class="loading">Loading</div>
                  <div class="error-message"></div>
                  <div class="sent-message">Your message has been sent. Thank you!</div>
                </div>
                <div class="text-center"><button type="submit">Send Message</button></div>
              </form>
            </div>
          </div>

        </div>

      </div>
    </section>
 <!-- end contact -->





















@endsection