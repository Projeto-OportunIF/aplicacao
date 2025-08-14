<!-- Adicione isso no <head> ou no seu arquivo CSS -->
<style>
    body {
        min-height: 100vh; /* ocupa altura total da tela */
        display: flex;
        flex-direction: column;
        margin: 0;
    }

    main {
        flex: 1; /* empurra o footer para baixo */
    }

    footer {
        margin-top: auto; /* garante que o footer fique colado no fim */
    }
</style>

<body>
    <main>
        <!-- Conteúdo da página -->
    </main>

    <!-- Footer -->
    <footer class="text-center text-lg-start bg-light text-muted">
        <div class="text-center p-4">
            © 2023 Copyright:
            <a class="text-reset fw-bold" href="https://foz.ifpr.edu.br" target="blank">IFPR (Campus Foz do Iguaçu)</a>
        </div>
    </footer>

    <!-- BOOTSTRAP: scripts requeridos pelo framework -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
