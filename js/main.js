let form = document.querySelector('.form')


form.addEventListener('submit', function (event) {
  // Zapobiegnij domyślnemu zachowaniu formularza (przekierowaniu)
  event.preventDefault();

  console.log(event);


  // Wyślij dane do Formspree za pomocą Fetch API lub innej metody
  // Przykład z użyciem Fetch:
  fetch(event.target.action, {
    method: form.method,
    mode: "cors",
    body: new FormData(event.target),
    headers: {
      'Accept': 'application/json'
    }
  })
    .then(response => {
      // Obsłuż odpowiedź, na przykład pokaż komunikat o sukcesie na stronie
      let nameInp = document.querySelector('.name')
      let emailInp = document.querySelector('.email')
      let massageInp = document.querySelector('.massage')
      let selectInp = document.querySelector('.service')

      nameInp.value = ''
      emailInp.value = ''
      massageInp.value = ''
      selectInp.value = ''


      let massSucc = document.querySelector('.success')
      massSucc.innerText  = "Sukces! Jak najszybciej skontaktujemy sie z Tobą :) "



    })
    .catch(error => {
      // Obsłuż błędy, na przykład pokaż komunikat o błędzie na stronie
      console.error('Wystąpił błąd podczas wysyłania danych:', error);
    });
});