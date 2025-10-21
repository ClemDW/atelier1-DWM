INSERT INTO public.reservations (id_reservation, id_utilisateur, date_debut, date_fin, statut, prix_total) VALUES
('a41ccf5c-9365-4232-a6e7-9b62740b60e6', 'fbdb2514-4caf-4864-afca-89b565f5eece', '2025-10-01', '2025-10-05', 'Validé', 175.00),
('f30cdbf8-0412-4dd5-a439-b8c173bf11cc', 'fbdb2514-4caf-4864-afca-89b565f5eece', '2025-10-02', '2025-10-02', 'En Attente', 0.00);

INSERT INTO public.reservation_outils (id_reservation, id_outil, quantite) VALUES
('a41ccf5c-9365-4232-a6e7-9b62740b60e6', '2cd179a8-d38d-441e-a31b-d88a6611cea1', 1),
('a41ccf5c-9365-4232-a6e7-9b62740b60e6', '0d13b42e-c5e4-4df1-bd7f-94dd71879f54', 1),
('f30cdbf8-0412-4dd5-a439-b8c173bf11cc', '19ff8036-6f39-4414-a70e-043684b7e7ef', 1);
