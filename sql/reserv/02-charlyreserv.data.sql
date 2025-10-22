INSERT INTO public.reservations (id_reservation, id_utilisateur, date_debut, date_fin, statut, prix_total) VALUES
('a41ccf5c-9365-4232-a6e7-9b62740b60e6', 'fbdb2514-4caf-4864-afca-89b565f5eece', '2025-10-01', '2025-10-05', 'Validé', 175.00),
('f30cdbf8-0412-4dd5-a439-b8c173bf11cc', 'fbdb2514-4caf-4864-afca-89b565f5eece', '2025-10-02', '2025-10-02', 'En Attente', 0.00),
('8a2f1c3d-9d4b-4f7a-b2c0-1a2b3c4d5e6f', 'fbdb2514-4caf-4864-afca-89b565f5eece', '2025-09-20', '2025-09-22', 'Terminé', 105.00),
('b7c3d2e1-2f4a-438b-a6b9-0f1e2d3c4b5a', 'fbdb2514-4caf-4864-afca-89b565f5eece', '2025-10-10', '2025-10-12', 'En Attente', 0.00),
('c1d2e3f4-1234-4abc-9def-0123456789ab', 'fbdb2514-4caf-4864-afca-89b565f5eece', '2025-11-01', '2025-11-07', 'Validé', 245.00),
('d4e5f6a7-89ab-4cde-b123-abcdef012345', 'fbdb2514-4caf-4864-afca-89b565f5eece', '2025-08-15', '2025-08-15', 'Annulé', 0.00),
('e5f6a7b8-90ab-4def-c234-1234567890ab', 'fbdb2514-4caf-4864-afca-89b565f5eece', '2025-12-20', '2025-12-27', 'Terminé', 560.00),
('f6a7b8c9-01ab-4abc-d345-abcd12345678', 'fbdb2514-4caf-4864-afca-89b565f5eece', '2026-01-05', '2026-01-06', 'En Attente', 0.00);


INSERT INTO public.reservation_outils (id_reservation, id_outil, quantite) VALUES
('a41ccf5c-9365-4232-a6e7-9b62740b60e6', '2cd179a8-d38d-441e-a31b-d88a6611cea1', 1),
('a41ccf5c-9365-4232-a6e7-9b62740b60e6', '0d13b42e-c5e4-4df1-bd7f-94dd71879f54', 1),
('f30cdbf8-0412-4dd5-a439-b8c173bf11cc', '19ff8036-6f39-4414-a70e-043684b7e7ef', 1);
('8a2f1c3d-9d4b-4f7a-b2c0-1a2b3c4d5e6f', '2cd179a8-d38d-441e-a31b-d88a6611cea1', 1),
('b7c3d2e1-2f4a-438b-a6b9-0f1e2d3c4b5a', '0652ec54-022a-45ed-8f2a-efbb29c728a0', 1),
('b7c3d2e1-2f4a-438b-a6b9-0f1e2d3c4b5a', 'bb295f57-3291-4c8f-830a-6bf53bf0c480', 1),
('c1d2e3f4-1234-4abc-9def-0123456789ab', '7cc2c89b-50c4-41a1-9ba3-8cb7bb49ee34', 1),
('d4e5f6a7-89ab-4cde-b123-abcdef012345', '19ff8036-6f39-4414-a70e-043684b7e7ef', 1),
('e5f6a7b8-90ab-4def-c234-1234567890ab', 'a75a3e1f-250c-405e-8831-7bed1ba95724', 1),
('e5f6a7b8-90ab-4def-c234-1234567890ab', '3efdba80-c65d-418f-86f2-923931eb5263', 1),
('f6a7b8c9-01ab-4abc-d345-abcd12345678', 'ef8b9c95-fb78-4f64-a192-7672c8090ba0', 2);


