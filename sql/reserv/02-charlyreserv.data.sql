INSERT INTO public.reservations (id_reservation, id_utilisateur, statut, prix_total) VALUES
('a41ccf5c-9365-4232-a6e7-9b62740b60e6', 'fbdb2514-4caf-4864-afca-89b565f5eece', 'Validé', 175.00),
('f30cdbf8-0412-4dd5-a439-b8c173bf11cc', 'fbdb2514-4caf-4864-afca-89b565f5eece', 'En Attente', 0.00),
('8a2f1c3d-9d4b-4f7a-b2c0-1a2b3c4d5e6f', 'fbdb2514-4caf-4864-afca-89b565f5eece', 'Terminé', 105.00),
('b7c3d2e1-2f4a-438b-a6b9-0f1e2d3c4b5a', 'fbdb2514-4caf-4864-afca-89b565f5eece', 'En Attente', 0.00),
('c1d2e3f4-1234-4abc-9def-0123456789ab', 'fbdb2514-4caf-4864-afca-89b565f5eece', 'Terminé', 245.00);

INSERT INTO public.reservation_outils (id_reservation, id_outil,  date_debut, date_fin) VALUES
('a41ccf5c-9365-4232-a6e7-9b62740b60e6', '2cd179a8-d38d-441e-a31b-d88a6611cea1', '2025-10-01', '2025-10-05'),
('a41ccf5c-9365-4232-a6e7-9b62740b60e6', '0d13b42e-c5e4-4df1-bd7f-94dd71879f54', '2025-10-02', '2025-10-02'),
('f30cdbf8-0412-4dd5-a439-b8c173bf11cc', '19ff8036-6f39-4414-a70e-043684b7e7ef', '2025-10-02', '2025-10-10');

