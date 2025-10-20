INSERT INTO public.reservations (id_reservation, id_utilisateur, date_debut, date_fin, statut, prix_total) VALUES
(gen_random_uuid(), 'fbdb2514-4caf-4864-afca-89b565f5eece', '2025-10-01', '2025-10-05', 'Validé', 175.00),
(gen_random_uuid(), 'fbdb2514-4caf-4864-afca-89b565f5eece', '2025-10-02', '2025-10-02', 'En Attente', 0.00)