// Inclure jQuery avant ce code

$(document).ready(function() {
    $('.delete-account-link').click(function(e) {
        e.preventDefault();
        
        var url = "deleteAccount"
        
        if (confirm('Êtes-vous sûr de vouloir supprimer votre compte ?')) {
            $.ajax({
                url: url,
                type: 'POST',
                success: function(response) {
                    // Redirection après suppression réussie
                    window.location.href = response.redirect;
                },
                error: function() {
                    // Gérer les erreurs
                }
            });
        }
    });
});