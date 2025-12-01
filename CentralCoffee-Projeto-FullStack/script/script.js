
// Central Coffee - Interações em JavaScript puro
// - Validação dos formulários de reserva (novo e edição)
// - Curiosidade aleatória na página Sobre

(function () {
  const page = window.location.pathname.split("/").pop();

  // ---------- Helpers ----------
  function $(selector) {
    return document.querySelector(selector);
  }

  function getErrorElement(fieldName) {
    return document.querySelector(`.error[data-for="${fieldName}"]`);
  }

  function clearErrors(form) {
    form.querySelectorAll(".error").forEach(function (el) {
      el.textContent = "";
    });
  }

  // ---------- Validação dos formulários de reserva ----------
  const reservationPages = ["reserva_form.php", "reservas_editar.php"];
  if (reservationPages.includes(page)) {
    const form = document.getElementById("reserva-form");

    if (form) {
      form.addEventListener("submit", function (event) {
        clearErrors(form);

        let isValid = true;

        const nome = form.nome.value.trim();
        if (nome.length < 3) {
          const el = getErrorElement("nome");
          if (el) el.textContent = "Informe pelo menos 3 caracteres.";
          isValid = false;
        }

        const email = form.email.value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
          const el = getErrorElement("email");
          if (el) el.textContent = "Informe um e-mail válido.";
          isValid = false;
        }

        const telefone = form.telefone.value.trim();
        if (telefone.length < 8) {
          const el = getErrorElement("telefone");
          if (el) el.textContent = "Digite um telefone válido.";
          isValid = false;
        }

        if (!form.data.value) {
          const el = getErrorElement("data");
          if (el) el.textContent = "Escolha a data da visita.";
          isValid = false;
        }

        if (!form.hora.value) {
          const el = getErrorElement("hora");
          if (el) el.textContent = "Escolha um horário.";
          isValid = false;
        }

        const pessoas = parseInt(form.pessoas.value, 10);
        if (isNaN(pessoas) || pessoas < 1 || pessoas > 10) {
          const el = getErrorElement("pessoas");
          if (el) el.textContent = "Informe um número entre 1 e 10.";
          isValid = false;
        }

        if (!form.assento.value) {
          const el = getErrorElement("assento");
          if (el) el.textContent = "Selecione uma preferência de assento.";
          isValid = false;
        }

        if (!isValid) {
          event.preventDefault();
        }
      });
    }
  }

  // ---------- Curiosidade na página Sobre ----------
  if (page === "about.php") {
    const btn = document.getElementById("btn-curiosidade");
    const texto = document.getElementById("texto-curiosidade");

    if (btn && texto) {
      const curiosidades = [
        "A Central Coffee foi pensada como um ponto de encontro para amigos que amam café, séries e conversas longas.",
        "Algumas bebidas do cardápio foram inspiradas em cenas clássicas de uma certa turma de amigos em Nova York.",
        "A ideia é que cada visita à Central Coffee pareça um novo episódio especial na sua rotina.",
        "O sofá é o coração da cafeteria: quem senta ali sempre acaba fazendo parte de alguma boa história."
      ];

      btn.addEventListener("click", function () {
        const indice = Math.floor(Math.random() * curiosidades.length);
        texto.textContent = curiosidades[indice];
      });
    }
  }
})();
